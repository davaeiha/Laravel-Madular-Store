<?php


use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Admin\PermissionController;
use Modules\User\Http\Controllers\Admin\UserController;

Route::resource("users", UserController::class);

Route::get("/users/{user}/permissions",[PermissionController::class,"create"])->name("users.permissions");
Route::post("/users/{user}/permissions",[PermissionController::class,"store"])->name("users.permissions.store");
