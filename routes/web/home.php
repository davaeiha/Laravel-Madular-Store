<?php


use App\Http\Controllers\Auth\AuthGoogleController;
use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Http\Controllers\DownloadController;
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
    $product = \Modules\CategoryProduct\Entities\Product::find(12);

    $attr = \Modules\CategoryProduct\Entities\Attribute::find(1);

     $product->attributes->each(function ($attr){
         dd($attr->pivot->value_id);
     });
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


//Route::post('/comments',[HomeController::class,'comment'])->name('send.comment');





Route::get('/wallet',function (){
    return "this is Hermodr wallet page";
})->middleware(['auth','password.confirm']);



//
//Route::get("/download/{file}",function ($file){
//
////    dd(Storage::disk('public')->exists($file));
//    $fileDirection =storage_path('app\public\files\\'.$file);
//    try {
//        if(Storage::disk('public')->exists('files\\'.$file)){
////            Storage::download(publi$file);
//            dd(url()->previous());
//            return Storage::disk('public')->download('files\\'.$file);
//            return response()->download(storage_path('app\public\files\\'.$file));
//        }
//    }catch(\Exception $e){
//
//        echo $e->getMessage();
//    }
//    dd(2);
////    Storage::download($fileDirection,"آبی");
//});

//
//Route::get('download',function (){
//    return URL::signedRoute("download.safe",["file"=>'blue.jpg']);
//});
//
//Route::get('download/{file}',function ($file){
//    return Storage::disk()
//})->name('download.safe');

Route::get('download/{file}',[DownloadController::class,"downloadPublic"])->name('download.file');
