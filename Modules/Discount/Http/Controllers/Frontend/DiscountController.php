<?php

namespace Modules\Discount\Http\Controllers\Frontend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Discount\Entities\Discount;
use Modules\Cart\Helpers\Cart;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class DiscountController extends Controller
{

    public function check(Request $request){


        $validatedCode = $request->validate([
            'code'=>['required','string','max:8'],
        ]);



        if(!Auth::check()){
            return back()
                ->withErrors([
                    'discount'=>'برای اعمال کد تخفیف واردسایت شوید'
                ]);
        }

        if(! in_array($validatedCode['code'],Discount::all()->pluck("code")->toArray())){
            return back()
                ->withErrors([
                    'discount'=>"کد وارد شده صحیح نمی باشد"
                ]);
        }

        if(!in_array($validatedCode['code'],$request->user()->discounts->pluck('code')->toArray())){
            return back()
                ->withErrors([
                    'discounts'=>"شما قادر به استفاده از این کد نمیباشید"
                ]);
        }

        if(Discount::whereCode($validatedCode['code'])->value('expired_at')< now() ){
            return back()
                ->withErrors([
                    'discount'=>"زمان استفاده از کد تخفیف گذشته است"
                ]);
        }

        $discount = Discount::where('code',$request->code)->first();

//        image::addDiscount($discount);
        Cart::addDiscount($discount);
        alert()->success("تخفیف مورد نظر با موفقیت اعمال شد");


        return back();

    }

    public function destroy(): RedirectResponse
    {
        Cart::removeDiscount();
        alert()->success("تخفیف مورد نظر با موفقیت حذف شد");
        return back();
    }
}
