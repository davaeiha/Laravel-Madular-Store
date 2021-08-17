<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Psy\Util\Str;

class AuthGitController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(){
        $gitUser = Socialite::driver('github')->stateless()->user();
        $user = DB::table('users')->where('email',$gitUser->email);
        dd($user);
        try {
            if($user){
                auth()->loginUsingId($user->id);
            }else{
                $newUser = User::create([
                    'id'=>$gitUser->getId(),
                    'email'=>$gitUser->getEmail(),
                    'name'=>$gitUser->getName(),
                    'password'=>bcrypt(\Str::random(16))
                ]);
            }

            alert('login successfully',"Success Github")->closeOnClickOutside();
            return redirect('/home');
        }catch (\Exception $exception){
            alert("login unsuccessful","Error")->confirmButton('OK');
            return redirect('/login');
        }
    }
}
