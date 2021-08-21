<?php


use Illuminate\Support\Facades\Route;
use Modules\RolePermission\Http\Controllers\admin\PermissionController;
use Modules\RolePermission\Http\Controllers\admin\RoleController;

Route::resource("permission", PermissionController::class);
Route::resource("roles", RoleController::class);
