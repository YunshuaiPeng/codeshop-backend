<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'show']);
    Route::put('/user', [\App\Http\Controllers\UserController::class, 'update']);
    Route::put('/password', [\App\Http\Controllers\PasswordController::class, 'update']);

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'show']);
    Route::post('/cart-items', [\App\Http\Controllers\CartItemController::class, 'store']);
    Route::delete('/cart-items/{cartItem}', [\App\Http\Controllers\CartItemController::class, 'destroy']);
});

Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show']);

Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'show']);
