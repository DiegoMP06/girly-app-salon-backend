<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World'
    ]);
});

Route::get('/reset-password', [PasswordController::class, 'index'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [PasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.reset.store');
