<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;

use App\Models\User;
use App\Notifications\LoginWebsiteNotification;
use App\Providers\RouteServiceProvider;
use App\Rules\recaptcha;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use TwoFactorAuth;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function validateLogin(Request $request)
    {
        $request->validate([
            $this->username()=>"required",
            "password"=>"required|string",
            "g-recaptcha-response"=>["required",new recaptcha()]
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
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
        $user=User::where("email",$request->email)->first();
        auth()->loginUsingId($user->id);
        $user->notify(new LoginWebsiteNotification());
        return false;
    }

}
