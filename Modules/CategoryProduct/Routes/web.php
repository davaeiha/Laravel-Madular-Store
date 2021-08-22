<?php

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

//products route

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CategoryProduct\Http\Controllers\Frontend\ProductController;

Route::get('/products',[ProductController::class,"index"])->name("products.all");
Route::get('/products/{product}',[ProductController::class,'single'])->name("products.single");

