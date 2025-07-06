<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordController::class, 'sendEmailPasswordReset'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::post('/profile', [ProfileController::class, 'profile'])
    ->middleware('auth:sanctum')
    ->name('profile.edit');

Route::post('/profile/password', [ProfileController::class, 'password'])
    ->middleware('auth:sanctum')
    ->name('profile.password');
