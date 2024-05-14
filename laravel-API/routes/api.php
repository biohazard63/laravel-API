<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OrderController;

Route::get('/v1/welcome', function () {
    return response()->json(['message' => 'Bienvenue sur notre API']);
});

// User routes
Route::get('v1/users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/users', [UserController::class, 'store'])->middleware('auth:sanctum');
Route::get('v1/users/{user}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::put('v1/users/{user}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::delete('v1/users/{user}', [UserController::class, 'destroy'])->middleware('auth:sanctum');

// Product routes
Route::get('v1/products', [ProductController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/products', [ProductController::class, 'store'])->middleware('auth:sanctum');
Route::get('v1/products/{product}', [ProductController::class, 'show'])->middleware('auth:sanctum');
Route::put('v1/products/{product}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('v1/products/{product}', [ProductController::class, 'destroy'])->middleware('auth:sanctum');

// Category routes
Route::get('v1/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/categories', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::get('v1/categories/{category}', [CategoryController::class, 'show'])->middleware('auth:sanctum');
Route::put('v1/categories/{category}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('v1/categories/{category}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');

// Order routes
Route::get('v1/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::get('v1/orders/{order}', [OrderController::class, 'show'])->middleware('auth:sanctum');
Route::put('v1/orders/{order}', [OrderController::class, 'update'])->middleware('auth:sanctum');
Route::delete('v1/orders/{order}', [OrderController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('v1/orders/{order}/products', [OrderController::class, 'addProduct'])->middleware('auth:sanctum');
Route::get('v1/users/{name}/orders', [OrderController::class, 'getUserOrders'])->middleware('auth:sanctum');

Route::post('v1/login', [UserController::class, 'login']);
Route::post('v1/register', [UserController::class, 'register']);
