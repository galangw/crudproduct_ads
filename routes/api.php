<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthApiController;

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

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::patch('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::post('/products/{product}/assets', [ProductController::class, 'addAsset']);
    Route::delete('/products/{product}/assets/{asset}', [ProductController::class, 'destroyAsset']);
});
