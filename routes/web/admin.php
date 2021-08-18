<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

//admin Routes

Route::get('/' , function() {
    return view('admin.index');
});








Route::get("comments/unapproved",[CommentController::class,"unapprovedComments"])->name("comments.unapproved");
Route::resource('comments', CommentController::class)->only(["index","destroy","update"]);



Route::resource('orders', OrderController::class);
Route::get('orders/{order}/payments',[OrderController::class,'payments'])->name('order.payments');

Route::resource('product.gallery', ProductGalleryController::class);


