<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\CustomerController;

Route::middleware(['auth:api'])->group(function () {
    //Use JWT to manage user sessions and protect API routes.
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    
    
    // Dashboard Routes
    Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
    Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('customers', CustomerController::class);
});

// Ruta para iniciar sesión y obtener el token JWT  
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::post('/forgot-password', [\App\Http\Controllers\Api\AuthController::class, 'forgotPassword'])->name('password.email');

Route::post('/reset-password', [\App\Http\Controllers\Api\AuthController::class, 'resetPassword'])->name('password.reset');

//endpoint para ver que esta conectado

Route::get('/endpoint', function () {
    return response()->json(['message' => 'Server is connected'], Response::HTTP_OK);
});