<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentServiceController;
use App\Http\Controllers\CategoryServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UpdateApointmentStatusController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\CanUpdateAppointmentStatus;
use App\Http\Middleware\IsUserAppontment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());

    Route::apiResource('/services', ServiceController::class)
        ->middleware([Admin::class]);

    Route::apiResource('/appointments', AppointmentController::class)
        ->only(['index', 'store']);

    Route::apiResource('/appointments', AppointmentController::class)
        ->only(['show', 'update', 'destroy'])
        ->middleware([IsUserAppontment::class]);

    Route::apiResource('/appointments/{appointment}/appointment-services', AppointmentServiceController::class)
        ->only(['index', 'store', 'destroy'])
        ->middleware([IsUserAppontment::class]);

    Route::post('/appointments/{appointment}/status', UpdateApointmentStatusController::class)
        ->name('appointments.status.update')
        ->middleware([CanUpdateAppointmentStatus::class]);
});

Route::get('/categories-service', CategoryServiceController::class)->name('category-service.index');

require_once __DIR__ . '/auth.php';
