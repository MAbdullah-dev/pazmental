<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user/get_profile/{id}', [UserController::class, 'get_profile']);
