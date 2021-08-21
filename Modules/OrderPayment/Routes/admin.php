<?php


/**
 * order routes in admin side
 *
 */

use Illuminate\Support\Facades\Route;
use Modules\OrderPayment\Http\Controllers\admin\OrderController;

Route::resource('orders', OrderController::class);
Route::get('orders/{order}/payments',[OrderController::class,'payments'])->name('order.payments');
