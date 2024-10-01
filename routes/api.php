<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;

// Public Routes - Accessible without authentication
Route::get('/customers', [ApiController::class, 'getCustomers']);
Route::get('/customers/{id}', [ApiController::class, 'getCustomerById']);

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Grouped routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    
    // Customer Routes (CRUD) - Requires authentication
    Route::get('/customers-auth', [CustomerController::class, 'index']);
    Route::get('/customers-auth/{id}', [CustomerController::class, 'show']);
    Route::post('/customers-auth', [CustomerController::class, 'store']);
    Route::put('/customers-auth/{id}', [CustomerController::class, 'update']);
    Route::delete('/customers-auth/{id}', [CustomerController::class, 'destroy']);
    Route::get('/customers-auth/{id}/gold-member', [CustomerController::class, 'checkGoldMember']);

    // Order Routes (One-to-Many for Customers and Orders)
    Route::get('/customers-auth/{customer_id}/orders', [OrderController::class, 'index']);
    Route::get('/customers-auth/{customer_id}/orders/{order_id}', [OrderController::class, 'show']);
    Route::post('/customers-auth/{customer_id}/orders', [OrderController::class, 'store']);
    Route::put('/customers-auth/{customer_id}/orders/{order_id}', [OrderController::class, 'update']);
    Route::delete('/customers-auth/{customer_id}/orders/{order_id}', [OrderController::class, 'destroy']);
});

// Optional fallback route for authenticated users
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
