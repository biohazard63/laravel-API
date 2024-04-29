<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;

Route::get('/v1/welcome', function () {
    return response()->json(['message' => 'Bienvenue sur notre API']);
});

Route::apiResource('v1/users', UserController::class);
Route::post('v1/login', [UserController::class, 'login']);
Route::post('v1/register', [UserController::class, 'register']);

Route::apiResource('v1/products', ProductController::class);

Route::apiResource('v1/categories', CategoryController::class);
