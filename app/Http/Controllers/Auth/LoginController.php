<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginWebsiteNotification;
use App\Providers\RouteServiceProvider;
use App\Rules\recaptcha;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\TwoFacAuth\Entities\ActiveCode;
use Modules\TwoFacAuth\Http\Controllers\Auth\TwoFactorAuth;
use Nwidart\Modules\Facades\Module;


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

    use AuthenticatesUsers,TwoFactorAuth;

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
        if(in_array('TwoFacAuth',Module::allEnabled())){
            return $this->loggedInVia2FA($request,$user);
        }
    }

}
