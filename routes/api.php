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

    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store']);
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index']);
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show']);

    Route::get('/mock-payments/{payment}', [\App\Http\Controllers\MockPaymentController::class, 'show']);
    Route::put('/mock-payments/{payment}', [\App\Http\Controllers\MockPaymentController::class, 'pay']);
});

Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show']);

Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'show']);
