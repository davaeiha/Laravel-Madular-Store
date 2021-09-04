<?php namespace Modules\TwoFacAuth\Http\Controllers\Auth;

use App\Models\User;
use App\Notifications\LoginWebsiteNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Modules\TwoFacAuth\Entities\ActiveCode;


trait TwoFactorAuth
{

    /**
     * @param Request $request
     * @param $user
     * @return false|Application|RedirectResponse|Redirector
     */
    public function loggedInVia2FA(Request $request, $user){
        if($user->hasEnabledType()){
            auth()->logout();
            $request->session()->flash("auth",[
                "using_sms"=>false,
                "user_id"=>$user->id,
                "remember"=>$request->has("remember")
            ]);
        }

        if( $user->type == "sms" ){
            //make session
            $request->session()->push("auth.using_sms",true);

            //create code
            $code = ActiveCode::generateCode($user);
            //TODO send sms

            return redirect(route("login.tokenForm"));
        }
        $user=User::where("email",$request->email)->first();
        auth()->loginUsingId($user->id);
        $user->notify(new LoginWebsiteNotification());
        return false;
    }

}
