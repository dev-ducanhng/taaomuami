<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoriController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Authenticate\AuthenticateController;
use App\Http\Controllers\Authenticate\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

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
<<<<<<< HEAD
        Route::get('/', [LoginController::class, 'index']);
    });
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/store', [CartController::class, 'store']);
        Route::delete('/deleted/{id}', [CartController::class, 'delete']);
    });
=======
        Route::get('/',[LoginController::class,'index']);
    });
    Route::prefix('products')->group(function () {
        Route::get('/',[ProductController::class,'index']);
        Route::get('/detail/{id}',[ProductController::class,'show']);
        Route::put('/detail/{id}',[ProductController::class,'update']);
        Route::post('/store',[ProductController::class,'store']);
        Route::delete('/{id}',[ProductController::class,'delete']);
    });
    
  
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
});
