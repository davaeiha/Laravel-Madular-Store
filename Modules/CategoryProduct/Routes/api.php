<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CategoryProduct\Http\Controllers\Api\v1\Frontend\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function (){
    Route::get('/products',[ProductController::class,"index"])->name("products.all");
    Route::get('/products/{product}',[ProductController::class,'single'])->name("products.single");
});

