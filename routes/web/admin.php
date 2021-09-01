<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

//admin Routes

Route::get('/' , function() {
    return view('admin.index');
});

Route::resource("users", UserController::class);

Route::get("/users/{user}/permissions",[PermissionController::class,"create"])->name("users.permissions");
Route::post("/users/{user}/permissions",[PermissionController::class,"store"])->name("users.permissions.store");
