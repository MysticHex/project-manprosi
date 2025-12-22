<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Api\AuthController;

// API authentication for token issuance
Route::post('/login', [AuthController::class, 'login']);

// Protected API routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::get('/user', [AuthController::class, 'user']);

	// API checkout route protected by sanctum token
	Route::post('/checkout', [CheckoutController::class, 'store']);
});