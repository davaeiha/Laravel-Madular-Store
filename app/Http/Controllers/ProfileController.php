<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use App\Notifications\ActiveCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.index');
    }

    public function tFacAuth(){
        return \view('profile.two-factor-auth');
    }

    public function manage2factorAuth(Request $request){
        $validatedData= $request->validate([
            "type"=>["required",Rule::in(['off','sms'])],
            "phone"=>['required_unless:type,off','numeric',Rule::unique("users","phone_number")->ignore($request->user()->id)]
        ]);

        if($validatedData['type'] === "sms"){
            //validate phone number
            if($validatedData["phone"] !== $request->user()->phone_number){
                // make a Code
                $request->session()->flash("phone_number",$validatedData["phone"]);
                $code = ActiveCode::generateCode($request->user());

                //TODO send sms to user
                $request->user()->notify(new ActiveCodeNotification($code));

                return redirect(route('getTokenForm'));
            }else{
                $request->user()->update([
                    "type"=>"sms"
                ]);
            }
        }

        if($validatedData["type"] === "off"){
            $request->user()->update([
                "type"=> "off",
            ]);
        }

        return back();
    }

    public function tokenForm(Request $request){
        if($request->session()->has("phone_number")){
            $request->session()->reflash();
            return \view('profile.token');
        }else{
            return \view("profile.two-factor-auth");
        }

    }

    public function postTokenForm(Request $request){

         $request->validate([
            "token"=>["numeric","required"]
        ]);

        $status = ActiveCode::verifyCode($request->token,$request->user());

        if($status){
            $request->user()->activeCode()->delete();
            $request->user()->update([
                "type"=>"sms",
                "phone_number"=>$request->session()->get('phone_number') //session("phone_number")
            ]);
        }
        return redirect(route("two-fac-auth"));
    }


}
