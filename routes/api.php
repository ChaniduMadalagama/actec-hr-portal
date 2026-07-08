<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\TechnicianController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Authentication Module
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // Admin Dashboard Operations (Protected by Sanctum and AdminMiddleware)
    Route::prefix('admin')->middleware(['auth:sanctum', 'role.admin'])->group(function () {
        Route::post('users/register', [AdminController::class, 'registerTechnician']);
        Route::get('users/technicians', [AdminController::class, 'listTechnicians']);
        Route::post('users/{id}/reset-password', [AdminController::class, 'resetTechnicianPassword']);
        
        Route::post('jobs', [AdminController::class, 'createJob']);
        Route::get('jobs', [AdminController::class, 'listJobs']);
        
        Route::get('logs/time-tracking', [AdminController::class, 'listTimeTrackingLogs']);
    });

    // Mobile App Operations (Protected by Sanctum and TechnicianMiddleware)
    Route::prefix('tech')->middleware(['auth:sanctum', 'role.technician'])->group(function () {
        Route::get('jobs/assigned', [TechnicianController::class, 'assignedJobs']);
        Route::get('jobs/{id}', [TechnicianController::class, 'jobDetails']);
        Route::post('jobs/{id}/start-route', [TechnicianController::class, 'startRoute']);
        Route::post('jobs/{id}/check-in', [TechnicianController::class, 'checkIn']);
        Route::post('jobs/{id}/check-out', [TechnicianController::class, 'checkOut']);
    });

});
