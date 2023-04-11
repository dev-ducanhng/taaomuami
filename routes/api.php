<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoriController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Authenticate\AuthenticateController;
use App\Http\Controllers\Authenticate\LoginController;

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


Route::post('/login', [AuthenticateController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [LoginController::class, 'index']);
    });

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/store', [CartController::class, 'store']);
        Route::delete('/deleted', [CartController::class, 'delete']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/show/{id}', [UserController::class, 'show']);
        Route::put('update', [UserController::class, 'update']);
    });

    Route::prefix('discount')->group(function () {
        Route::get('/', [DiscountController::class, 'index']);
        Route::post('/store', [DiscountController::class, 'store']);
        Route::put('update/{id}', [DiscountController::class, 'update']);
        Route::get('/{id}', [DiscountController::class, 'show']);
        Route::delete('/deleted/{id}', [DiscountController::class, 'delete']);
    });
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/detail/{id}', [ProductController::class, 'show']);
        Route::post('/store', [ProductController::class, 'store']);
        Route::put('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    });
    
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoriController::class, 'index']);
        Route::post('/show/{id}', [CategoriController::class, 'show']);
        Route::post('/store', [CategoriController::class, 'store']);
        Route::put('/update/{id}', [CategoriController::class, 'update']);
        Route::delete('/{id}', [CategoriController::class, 'delete']);
    });

});





