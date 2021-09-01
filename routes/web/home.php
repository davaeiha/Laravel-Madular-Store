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


//phone verify login route
Route::get("/login/verifyPhone",[VerifyPhoneController::class,"getVerifyPhone"])->name("login.getVerifyPhone");
Route::post("/login/verifyPhone",[VerifyPhoneController::class,"postVerifyPhone"])->name("login.postVerifyPhone");

//home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//profile panel
Route::middleware(['auth'])->prefix("profile")->group(function (){

    Route::get('/',[ProfileController::class,'index'])->middleware("verified")->name('index');

    //two factor auth
    Route::get('/two-factor-auth',[ProfileController::class,"tFacAuth"])->name('two-fac-auth');
    Route::post('/two-factor-auth',[ProfileController::class,'manage2factorAuth']);

    //Token Form Routes
    Route::get('/two-factor-auth/token',[ProfileController::class,"tokenForm"])->name("getTokenForm");
    Route::post('/two-factor-auth/token',[ProfileController::class,"postTokenForm"])->name("postTokenForm");



});


Route::get('/wallet',function (){
    return "this is Hermodr wallet page";
})->middleware(['auth','password.confirm']);


