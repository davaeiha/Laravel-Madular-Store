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

//profile panel
use Illuminate\Support\Facades\Route;
use Modules\TwoFacAuth\Http\Controllers\Profile\ProfileController;

Route::middleware(['auth'])->name('profile.')->prefix("profile")->group(function (){

    //index profile
    Route::get('/',[ProfileController::class,'index'])->middleware("verified")->name('index');

    //two-factor auth
    Route::get('/two-factor-auth',[ProfileController::class,"showTwoFacAuthForm"])->name('2FA.show');
    Route::post('/two-factor-auth',[ProfileController::class,'storeTwoFacAuthForm'])->name('2FA.store');

    //Token Form Routes
    Route::get('/two-factor-auth/token',[ProfileController::class,"tokenForm"])->name("tokenForm");
    Route::post('/two-factor-auth/token',[ProfileController::class,"verifyTokenForm"])->name("verifyToken");

});
