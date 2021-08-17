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


Route::resource("users", UserController::class);

Route::get("/users/{user}/permissions",[\App\Http\Controllers\Admin\User\PermissionController::class,"create"])->name("users.permissions");
Route::post("/users/{user}/permissions",[\App\Http\Controllers\Admin\User\PermissionController::class,"store"])->name("users.permissions.store");

Route::resource("permission", PermissionController::class);
Route::resource("roles", RoleController::class);

Route::resource('products',ProductController::class);

Route::get("comments/unapproved",[CommentController::class,"unapprovedComments"])->name("comments.unapproved");
Route::resource('comments', CommentController::class)->only(["index","destroy","update"]);

Route::resource("categories",CategoryController::class);

Route::resource('orders', OrderController::class);
Route::get('orders/{order}/payments',[OrderController::class,'payments'])->name('order.payments');

Route::resource('product.gallery', ProductGalleryController::class);


