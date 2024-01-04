<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;






Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', function () {
        return view('home');
    });
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});

Auth::routes();
