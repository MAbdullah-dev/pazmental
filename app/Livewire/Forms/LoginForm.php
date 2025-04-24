<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function authenticate(): void
    // {
    //     $this->ensureIsNotRateLimited();

    //     if (!Auth::attempt($this->only(['email', 'password']), $this->remember)) {
    //         RateLimiter::hit($this->throttleKey());

    //         throw ValidationException::withMessages([
    //             'form.email' => trans('auth.failed'),
    //         ]);
    //     }

    //     RateLimiter::clear($this->throttleKey());
    // }

    public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    $credentials = $this->only(['email', 'password']);

    // Try standard Laravel auth
    if (Auth::attempt($credentials, $this->remember)) {
        RateLimiter::clear($this->throttleKey());
        return;
    }

    // Get user manually to handle $wp$ prefixed bcrypt
    $user = WPUser::where('user_email', $credentials['email'])->first();

    if (!$user) {
        $this->failLogin();
    }

    $hashed = $user->user_pass;

    // Handle $wp$ bcrypt hashes
    if (str_starts_with($hashed, '$wp$2y$')) {
        $realHash = str_replace('$wp$', '', $hashed);

        if (password_verify($credentials['password'], $realHash)) {
            // Optionally rehash and save to clean up
            // $user->user_pass = bcrypt($credentials['password']);
            // $user->save();

            Auth::login($user, $this->remember);
            RateLimiter::clear($this->throttleKey());
            return;
        }
    }

    $this->failLogin();
}

protected function failLogin()
{
    RateLimiter::hit($this->throttleKey());

    throw ValidationException::withMessages([
        'form.email' => trans('auth.failed'),
    ]);
}

    public function authenticateadmin(): void
    {

        $this->ensureIsNotRateLimited();

        if (!Auth::guard('admin')->attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }


    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
