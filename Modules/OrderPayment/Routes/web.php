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
use Modules\OrderPayment\Http\Controllers\PaymentController;
use Modules\OrderPayment\Http\Controllers\profile\OrderController;

/**
 * order routes in the profile side
 *
 *
 */
Route::middleware(['auth'])->prefix('/profile')->group(function (){
    Route::get('/orders',[OrderController::class,"index"])->name("profile.orders");
    Route::get('/orders/{order}',[OrderController::class,'showDetails'])->name('profile.order.detail');
    Route::get('/orders/{order}/pay',[OrderController::class,"payment"])->name('profile.order.pay');
});

/**
 * payment routes
 *
 */

Route::middleware('auth')->prefix('payment')->group(function (){
    Route::post("/",[PaymentController::class,'payment'])->name("payment.post");
    Route::get("/callback",[PaymentController::class,"callback"])->name("payment.callback");
});
