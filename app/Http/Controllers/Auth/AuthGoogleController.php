<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $googleUser = Socialite::driver('google')->user();
        $user = DB::table('users')->where('email',$googleUser->email)->first();
        try {
            if($user){
                auth()->loginUsingId($user->id);
            }else{
                $newUser = User::create([
                    'name'=>$googleUser->getName(),
                    'email'=>$googleUser->getEmail(),
                    'password'=>bcrypt(Str::random(16))
                ]);

                auth()->loginUsingId($newUser->id);
            }
            alert()->success("login successfully",'Success');
            return redirect('/home');
        }catch (\Exception $exception){
            alert()->error('login was not successful','Error');
            return redirect("/login");
        }
    }

}
