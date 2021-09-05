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

//Google Auth
use Illuminate\Support\Facades\Route;
use Modules\GoogleAuth\Http\Controllers\GoogleAuthController;

Route::get('/auth/google',[GoogleAuthController::class,"redirect"])->name('GoogleAuth');
Route::get('/auth/google/callback',[GoogleAuthController::class,"callback"]);
