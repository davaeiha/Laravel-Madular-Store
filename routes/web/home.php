<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Modules\OrderPayment\Events\Paid;

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
    $paying = \Modules\OrderPayment\Entities\Payment::find(26);
    $event = event(new Paid($paying));
    return view('welcome');
});

Auth::routes(['verify'=> true]);

//home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//profile panel
Route::middleware(['auth'])->name('profile.')->prefix("profile")->group(function () {
    //index profile
    Route::get('/', function (){
        return view('profile.index');
    })->middleware("verified")->name('index');
});


Route::get('/wallet',function (){
    return "this is Hermodr wallet page";
})->middleware(['auth','password.confirm']);


