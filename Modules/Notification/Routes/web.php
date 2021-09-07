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
use Modules\Notification\Http\Controllers\Profile\NotificationController;

Route::middleware('auth')->prefix('/profile/notifications')->name('profile.')->group(function(){

    //show all notifications
    Route::get('/',[NotificationController::class,'index'])->name('notifications');

    //validate and store notification
    Route::patch('/save',[NotificationController::class,'store'])->name('notifications.save');
});

