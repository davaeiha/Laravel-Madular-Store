<?php


namespace App\Http\Controllers\Auth;


use App\Models\ActiveCode;
use App\Notifications\LoginWebsiteNotification;
use http\Env\Request;

trait TwoFactorAuth
{
    public function loggendIn(Request $request,$user){
        if($user->hasEnabledType()){
            auth()->logout();
            $request->session()->flash("auth",[
                "using_sms"=>false,
                "user_id"=>$user->id,
                "remember"=>$request->has("remember")
            ]);
        }

        if( $user->type == "sms" ){
            $request->session()->push("auth.using_sms",true);
            //TODO create code
            $code = ActiveCode::generateCode($user);

            //TODO send sms

            return redirect(route("login.getVerifyPhone"));
        }

        $user->notify(new LoginWebsiteNotification());
        return false;
    }

}
