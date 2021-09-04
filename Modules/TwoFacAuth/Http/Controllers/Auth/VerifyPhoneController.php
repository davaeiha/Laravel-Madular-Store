<?php

namespace Modules\TwoFacAuth\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\TwoFacAuth\Entities\ActiveCode;

class VerifyPhoneController extends Controller
{
    public function tokenPhoneForm(Request $request){
        $request->session()->reflash();
        if($request->session()->has("auth")){
            return view("auth.passwords.token");
        }

        return redirect("/");
    }

    public function verifyTokenPhone(Request $request){
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

        alert()->success("ورود با موفقیت انجام شد");

        return redirect("/home");

    }
}
