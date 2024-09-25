<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

// Default route provided in the original code
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/customers', [CustomerController::class, 'index']);


Route::get('/customers/{id}', [CustomerController::class, 'show']);

Route::post('/customers', [CustomerController::class, 'store']);

Route::put('/customers/{id}', [CustomerController::class, 'update']);

Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

Route::get('/customers/{id}/gold-member', [CustomerController::class, 'checkGoldMember']);

Route::get('/customers/{customer_id}/orders', [OrderController::class, 'index']);
Route::get('/customers/{customer_id}/orders/{order_id}', [OrderController::class, 'show']);
Route::post('/customers/{customer_id}/orders', [OrderController::class, 'store']);
Route::put('/customers/{customer_id}/orders/{order_id}', [OrderController::class, 'update']);
Route::delete('/customers/{customer_id}/orders/{order_id}', [OrderController::class, 'destroy']);

