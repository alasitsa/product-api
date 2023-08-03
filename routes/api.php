<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('getAllProducts', [\App\Http\Controllers\ProductController::class, 'getAll']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('getUserProducts', [\App\Http\Controllers\ProductController::class, 'getUserProducts']);
    Route::post('rent', [\App\Http\Controllers\ProductController::class, 'rent']);
    Route::post('extendRent', [\App\Http\Controllers\ProductController::class, 'extendRent']);
    Route::post('buy', [\App\Http\Controllers\ProductController::class, 'buy']);
    Route::get('getUser', [\App\Http\Controllers\UserController::class, 'getUser']);
    Route::get('getHistory', [\App\Http\Controllers\HistoryController::class, 'getHistory']);
});

