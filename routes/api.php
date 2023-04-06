<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Authenticate\AuthenticateController;
use App\Http\Controllers\Authenticate\LoginController;
use Illuminate\Http\Request;
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


Route::post('/login',[AuthenticateController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/',[LoginController::class,'index']);
    });
    Route::prefix('products')->group(function () {
        Route::get('/',[ProductController::class,'index']);
        Route::get('/detail/{id}',[ProductController::class,'show']);
        Route::put('/detail/{id}',[ProductController::class,'update']);
        Route::post('/store',[ProductController::class,'store']);
        Route::delete('/{id}',[ProductController::class,'delete']);
    });
    
  
});
   
