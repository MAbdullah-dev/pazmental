<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get_profile($id) {
        $profilePicture = getProfilePicture($id);
        // return response 
        return response()->json([
            'profile_picture' => $profilePicture
        ]);
    }
}
