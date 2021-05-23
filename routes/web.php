<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [\App\Http\Controllers\SessionController::class, 'store']);

Route::post('/logout', [\App\Http\Controllers\SessionController::class, 'destroy']);

Route::post('/register', [\App\Http\Controllers\UserController::class, 'store']);

Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\VerificationController::class, 'verify'])->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/resend', [\App\Http\Controllers\VerificationController::class, 'resend'])->middleware('auth:sanctum')->name('verification.send');

Route::post('/password/forgot', [\App\Http\Controllers\PasswordController::class, 'forgot']);

Route::post('/password/reset', [\App\Http\Controllers\PasswordController::class, 'reset']);
