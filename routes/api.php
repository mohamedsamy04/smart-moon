<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DirectCheckoutController;
use App\Http\Controllers\CartCheckoutController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Admin Login (public - no authentication required)
Route::post('/admin/login', [AuthController::class, 'login']);

// Admin Protected Routes (require authentication)
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Categories Management
    Route::post('/store-category', [CategoryController::class, 'store']);
    Route::put('/update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('/delete-category/{id}', [CategoryController::class, 'destroy']);

    // Products Management
    Route::post('/store-product', [ProductController::class, 'store']);
    Route::put('/update-product/{id}', [ProductController::class, 'update']);
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);

    // Orders Management
    Route::patch('/update-order-status/{orderId}', [AdminOrderController::class, 'updateStatus']);
    Route::delete('/delete-order/{orderId}', [AdminOrderController::class, 'deleteOrder']);
    Route::get('/orders', [AdminOrderController::class, 'index']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'index']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('cart', [CartController::class, 'index']);
Route::post('cart', [CartController::class, 'add']);
Route::patch('cart/{productId}', [CartController::class, 'update']);
Route::delete('cart/{id}', [CartController::class, 'remove']);

Route::post('direct-checkout', [DirectCheckoutController::class, 'checkout']);
Route::post('cart-checkout', [CartCheckoutController::class, 'checkout']);

