<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Models\User;
use App\Notifications\LoginWebsiteNotification;
use Illuminate\Http\Request;

class VerifyPhoneController extends Controller
{
    public function getVerifyPhone(Request $request){
        $request->session()->reflash();
        if($request->session()->has("auth")){
            return view("auth.passwords.token");
        }

        return redirect("/");
    }

    public function postVerifyPhone(Request $request){
        $request->validate([
            "token"=>["required","numeric"]
        ]);

        $user = User::findOrFail($request->session()->get("auth.user_id"));

        $status = ActiveCode::verifyCode($request->token,$user);
        if (!$status){
            return redirect(route("login"));
        }
        $user->activeCode()->delete();
        auth()->loginUsingId($user->id);

        alert()->success("logged in successfully","Success");
        return redirect("/home");

    }



}
