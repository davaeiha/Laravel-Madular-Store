<?php


use App\Http\Controllers\Auth\AuthGoogleController;
use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=> true]);

//Google Auth
Route::get('/auth/google',[AuthGoogleController::class,"redirect"])->name('GoogleAuth');
Route::get('/auth/google/callback',[AuthGoogleController::class,"callback"]);




//home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





Route::get('/wallet',function (){
    return "this is Hermodr wallet page";
})->middleware(['auth','password.confirm']);


