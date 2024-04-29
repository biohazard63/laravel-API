<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;

Route::get('/v1/welcome', function () {
    return response()->json(['message' => 'Bienvenue sur notre API']);
});

// User routes
Route::get('v1/users', [UserController::class, 'index']);
Route::post('v1/users', [UserController::class, 'store']);
Route::get('v1/users/{user}', [UserController::class, 'show']);
Route::put('v1/users/{user}', [UserController::class, 'update']);
Route::delete('v1/users/{user}', [UserController::class, 'destroy']);

// Product routes
Route::get('v1/products', [ProductController::class, 'index']);
Route::post('v1/products', [ProductController::class, 'store']);
Route::get('v1/products/{product}', [ProductController::class, 'show']);
Route::put('v1/products/{product}', [ProductController::class, 'update']);
Route::delete('v1/products/{product}', [ProductController::class, 'destroy']);

// Category routes
Route::get('v1/categories', [CategoryController::class, 'index']);
Route::post('v1/categories', [CategoryController::class, 'store']);
Route::get('v1/categories/{category}', [CategoryController::class, 'show']);
Route::put('v1/categories/{category}', [CategoryController::class, 'update']);
Route::delete('v1/categories/{category}', [CategoryController::class, 'destroy']);

Route::post('v1/login', [UserController::class, 'login']);
Route::post('v1/register', [UserController::class, 'register']);
