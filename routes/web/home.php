<?php

use App\Http\Controllers\Auth\AuthGitController;
use App\Http\Controllers\Auth\AuthGoogleController;
use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentController1;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\OrderController;
use App\Http\Controllers\ProfileController;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Nwidart\Modules\Facades\Module;

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
    $product = Product::find(4);

//    auth()->user()->comments()->create([
//        "comment"=>"this is the first comment",
//        "commentable_id"=>$product->id,
//        "commentable_type"=>get_class($product),
//        "user_id"=>auth()->user()->id
//    ]);
//
//    return $product->comments()->get();
//    \auth()->loginUsingId(1);
    return view('welcome');
});

Route::get("/test",function(){
//    $product = \App\Models\Product::find(4);
    // adding comment by user
    /*\auth()->user()->comments()->create([
        "commentable_id"=>$product->id,
        "commentable_type"=>get_class($product),
        "user_id"=>auth()->user()->id,
        "comment"=>"this is the first comment",
    ]);*/

    //adding comment by product
    /*$product->comments()->create([
        "user_id"=> auth()->user()->id,
        "comment"=>"this is the second comment",
    ]);*/

    $module = Module::find('discount');
    dd(Module::allEnabled());

    dd(session('cart'));
    $category = \App\Models\Category::findOrFail(5);
    dd($category->products);
    $image = \App\Models\ProductGallery::find(18);
    dd($image->path());
//    dd($image->getFile());
    dd(\App\Helpers\cart\Cart::all());
   $category = \App\Models\Category::find(13);
//   dd($category->child);
    dd($category->child->isEmpty());

   dd(is_null($category->child));
   $category->child()->each(function ($category){
      dd($category->is_empry());
   });

});

Auth::routes(['verify'=> true]);

//Google Auth
Route::get('/auth/google',[AuthGoogleController::class,"redirect"])->name('GoogleAuth');
Route::get('/auth/google/callback',[AuthGoogleController::class,"callback"]);

//Github Auth
Route::get('/auth/github',[AuthGitController::class,"redirect"])->name('GitAuth');
Route::get('/auth/github/callback',[AuthGitController::class,'callback']);


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

    //orders routes
    Route::get('/orders',[OrderController::class,"index"])->name("profile.orders");
    Route::get('/orders/{order}',[OrderController::class,'showDetails'])->name('profile.order.detail');
    Route::get('/orders/{order}/pay',[OrderController::class,"payment"])->name('profile.order.pay');

});
//products route
Route::get('/products',[ProductController::class,"index"])->name("products.all");
Route::get('/products/{product}',[ProductController::class,'single'])->name("products.single");
//article routes

//comment routes
Route::post("/comments/product/{product}",[HomeController::class,"comment"])->name("send.comment");

//cart routs
//Route::get('cart',[CartController::class,'showCart']);
//Route::delete('cart/remove/{id}',[CartController::class,"removeCart"])->name("cart.remove");
//Route::post("cart/add/{product}",[CartController::class,"addToCart"])->name("cart.add");
//Route::patch("/cart/quantity/change",[CartController::class,"changeQuantity"])->name('cart.update');

//order and payment routes

Route::middleware('auth')->prefix('payment')->group(function (){
    //based on pay-ping package
//    Route::post("payment",[PaymentController1::class,"payment"])->name("payment.post");
//    Route::get("payment/callback",[\App\Http\Controllers\PaymentController1::class,"paymentCallback"])->name("payment.callback");

    //based on multi terminal package
    Route::post("/",[PaymentController::class,'payment'])->name("payment.post");
    Route::get("/callback",[PaymentController::class,"callback"])->name("payment.callback");
});

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
