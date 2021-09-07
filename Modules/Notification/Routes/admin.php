<?php


use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\Admin\ChannelController;
use Modules\Notification\Http\Controllers\Admin\NotificationController;

Route::resource('notifications', NotificationController::class);
Route::resource('channels', ChannelController::class);
