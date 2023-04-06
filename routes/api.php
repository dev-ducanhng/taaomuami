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
    Route::get('/users',[LoginController::class,'index']);
    Route::get('/index',[ProductController::class,'index']);
    Route::get('/request',[ProductController::class,'request']);
    Route::post('/addproduct',[ProductController::class,'addProduct']);
    Route::post('/update',[ProductController::class,'update']);
    Route::post('/deleted',[ProductController::class,'delete']);
});
   
