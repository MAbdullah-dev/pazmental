<?php

namespace App\Http\Controllers\Auth;

use App\Models\Wordpress\User;

use App\Http\Controllers\Controller;
use App\Models\PatientDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginQrController extends Controller
{
    public function verifyLogin($encryptedEmail)
    {
        try {
            //$email = Crypt::decryptString($encryptedEmail);
            $user = User::where('user_email', $encryptedEmail)->first('id');
            // Auth::login($user);
            $id = $user->id;
            return redirect()->route('patient-details/', $id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'Unauthorized action.');
        }
    }
}
