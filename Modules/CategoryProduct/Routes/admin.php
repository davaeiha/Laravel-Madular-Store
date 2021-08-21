<?php

use Illuminate\Support\Facades\Route;
use Modules\CategoryProduct\Http\Controllers\Admin\CategoryController;
use Modules\CategoryProduct\Http\Controllers\Admin\ProductController;

Route::resource('products',ProductController::class);
Route::resource("categories",CategoryController::class);
