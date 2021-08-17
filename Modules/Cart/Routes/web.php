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

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\Frontend\CartController;

/**
 * routes of the module cart
 */

Route::prefix('cart')->group(function() {
    Route::get('/',[CartController::class,'showCart']);
    Route::delete('/remove/{id}',[CartController::class,"removeCart"])->name("cart.remove");
    Route::post("/add/{product}",[CartController::class,"addToCart"])->name("cart.add");
    Route::patch("/quantity/change",[CartController::class,"changeQuantity"])->name('cart.update');
});
