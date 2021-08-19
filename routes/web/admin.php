<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

//admin Routes

Route::get('/' , function() {
    return view('admin.index');
});











Route::resource('orders', OrderController::class);
Route::get('orders/{order}/payments',[OrderController::class,'payments'])->name('order.payments');




