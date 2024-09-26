<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Grouped routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    
    // Customer Routes
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
    Route::get('/customers/{id}/gold-member', [CustomerController::class, 'checkGoldMember']);

    // Order Routes (One-to-Many for Customers and Orders)
    Route::get('/customers/{customer_id}/orders', [OrderController::class, 'index']);
    Route::get('/customers/{customer_id}/orders/{order_id}', [OrderController::class, 'show']);
    Route::post('/customers/{customer_id}/orders', [OrderController::class, 'store']);
    Route::put('/customers/{customer_id}/orders/{order_id}', [OrderController::class, 'update']);
    Route::delete('/customers/{customer_id}/orders/{order_id}', [OrderController::class, 'destroy']);
});

// Fallback route if the user is not authenticated (Optional)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
