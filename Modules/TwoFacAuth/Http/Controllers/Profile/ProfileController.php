<?php

namespace Modules\TwoFacAuth\Http\Controllers\Profile;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Modules\TwoFacAuth\Entities\ActiveCode;
use Modules\TwoFacAuth\Notifications\ActiveCodeNotification;
use function PHPUnit\Framework\isNull;

class ProfileController extends Controller
{

    /**
     *two-factor Authentication form of profile
     *
     * @return Application|Factory|View
     */
    public function showTwoFacAuthForm(){
        return \view('twofacauth::profile.two-factor-auth');
    }

    /**
     * store user`s information including type and phone number
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function storeTwoFacAuthForm(Request $request){

        //validation
        $validatedData= $request->validate([
            "type"=>["required",Rule::in(['off','sms'])],
            "phone"=>['required_unless:type,off','numeric',Rule::unique("users","phone_number")->ignore($request->user()->id)]
        ]);

        if($validatedData['type'] == 'sms'){

            //validate phone number
            if(
                ($validatedData['phone'] !== $request->user()->phone_number)
                ||
                ($request->user()->type == 'off' && $validatedData['phone'] === $request->user()->phone_number)
            ){
                // make a Code
                $request->session()->flash("phone_number",$validatedData["phone"]);
                $code = ActiveCode::generateCode($request->user());
                // send sms to user
                $request->user()->notify(new ActiveCodeNotification($code,$validatedData['phone']));
                //redirect back to the two-factor form
                return redirect(route('profile.tokenForm'));
            }

        }else{
            $request->user()->update([
                'type'=>$validatedData['type'],
                'phone_number'=>$validatedData['phone']
            ]);
        }

        alert()->success('اطلاعات شما با موفقیت ثبت شد');

        return back();
    }

    /**
     * show token form if two-factor authentication is on
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function tokenForm(Request $request){
        if($request->session()->has("phone_number")){
            $request->session()->reflash();
            return \view('twofacauth::profile.token');
        }else{
            return \view("twofacauth::profile.two-factor-auth");
        }

    }

    /**
     * verify sent code via sms
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function verifyTokenForm(Request $request){

        $request->validate([
            "token"=>["numeric","required"]
        ]);

        $status = ActiveCode::verifyCode($request->token,$request->user());

        if($status){
            $request->user()->activeCode()->delete();
            $request->user()->update([
                "type"=>"sms",
                "phone_number"=>$request->session()->get('phone_number')
            ]);
        }

        alert()->success('احراز دو مرحله ای شما با موفقیت انجام شد.');

        return redirect(route('profile.2FA.show'));
    }
}
