<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Wordpress\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        $user = User::where('user_email', $this->email)->first();

        if (!$user) {
            Log::warning('Login failed: user not found', ['email' => $this->email]);
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        if (!$this->checkPassword($this->password, $user->user_pass)) {
            Log::warning('Login failed: password mismatch', ['email' => $this->email]);
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        Log::info('User login successful', ['email' => $this->email]);

        Auth::login($user, $this->remember);

        RateLimiter::clear($this->throttleKey());
    }

    protected function checkPassword(string $plainPassword, string $hashedPassword): bool
    {
        try {

            if (Str::startsWith($hashedPassword, '$P$')) {
    Log::debug('phpass style hash detected', ['email' => $this->email]);

    $result = $this->verifyPhpassHash($plainPassword, $hashedPassword);

    Log::debug('phpass password verify result', ['result' => $result]);
    return $result;
}


            if (Str::startsWith($hashedPassword, '$wp$')) {
                Log::debug('WordPress style hash detected', ['email' => $this->email]);

                $bcryptHash = substr($hashedPassword, 3);
                $preHash = base64_encode(hash_hmac('sha384', trim($plainPassword), 'wp-sha384', true));

                $result = password_verify($preHash, $bcryptHash);
                Log::debug('WordPress password verify result', ['result' => $result]);

                return $result;
            }

            Log::debug('Laravel style hash detected', ['email' => $this->email]);

            $result = Hash::check($plainPassword, $hashedPassword);
            Log::debug('Laravel password verify result', ['result' => $result]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Password check error', [
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    protected function verifyPhpassHash(string $password, string $hash): bool
{
    $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    if (strlen($hash) !== 34 || substr($hash, 0, 3) !== '$P$') {
        return false;
    }

    $count_log2 = strpos($itoa64, $hash[3]);
    if ($count_log2 < 7 || $count_log2 > 30) {
        return false;
    }

    $count = 1 << $count_log2;
    $salt = substr($hash, 4, 8);

    if (strlen($salt) !== 8) {
        return false;
    }

    $hash_output = md5($salt . $password, true);
    for ($i = 0; $i < $count; $i++) {
        $hash_output = md5($hash_output . $password, true);
    }

    $encoded = $this->encode64($hash_output, 16, $itoa64);

    return substr($hash, 0, 12) . $encoded === $hash;
}

protected function encode64(string $input, int $count, string $itoa64): string
{
    $output = '';
    $i = 0;

    do {
        $value = ord($input[$i++]);
        $output .= $itoa64[$value & 0x3f];

        if ($i < $count) {
            $value |= ord($input[$i]) << 8;
        }

        $output .= $itoa64[($value >> 6) & 0x3f];

        if ($i++ >= $count) {
            break;
        }

        if ($i < $count) {
            $value |= ord($input[$i]) << 16;
        }

        $output .= $itoa64[($value >> 12) & 0x3f];

        if ($i++ >= $count) {
            break;
        }

        $output .= $itoa64[($value >> 18) & 0x3f];
    } while ($i < $count);

    return $output;
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
