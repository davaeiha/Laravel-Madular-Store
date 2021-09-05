<?php

namespace Modules\GoogleAuth\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleAuthController extends Controller
{
    /**
     *  redirect to google authentication
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * call back function and interacting with database
     *
     * @return Application|\Illuminate\Http\RedirectResponse|Redirector
     */
    public function callback(){
        //google user
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email',$googleUser->email)->first();
        try {
            if($user){
                //login user
                auth()->loginUsingId($user->id);
            }else{
                //create new user based on Google account information
                $newUser = User::create([
                    'name'=>$googleUser->getName(),
                    'email'=>$googleUser->getEmail(),
                    'password'=>bcrypt(Str::random(16))
                ]);
                //login new user
                auth()->loginUsingId($newUser->id);
            }
            alert()->success("ورود با موفقیت انجام شد");
            return redirect('/home');
        }catch (\Exception $exception){
            alert()->error('ورود انجام نشد');
            return redirect("/login");
        }
    }
}
