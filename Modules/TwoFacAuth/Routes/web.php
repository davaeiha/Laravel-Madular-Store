<?php
use Illuminate\Support\Facades\Route;
use Modules\TwoFacAuth\Http\Controllers\Auth\VerifyPhoneController;
use Modules\TwoFacAuth\Http\Controllers\Profile\ProfileController;
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

//profile Two-fac panel
Route::middleware(['auth'])->name('profile.')->prefix("profile")->group(function (){

    //two-factor auth
    Route::get('/two-factor-auth',[ProfileController::class,"showTwoFacAuthForm"])->name('2FA.show');
    Route::post('/two-factor-auth',[ProfileController::class,'storeTwoFacAuthForm'])->name('2FA.store');

    //Token Form Routes
    Route::get('/two-factor-auth/token',[ProfileController::class,"tokenForm"])->name("tokenForm");
    Route::post('/two-factor-auth/token',[ProfileController::class,"verifyTokenForm"])->name("verifyToken");
});

//phone verify login route
Route::prefix('/login/verifyPhone')->name('login.')->group(function (){
    Route::get('',[VerifyPhoneController::class,"tokenPhoneForm"])->name("tokenForm");
    Route::post('',[VerifyPhoneController::class,"verifyTokenPhone"])->name("verifyTokenPhone");
});


