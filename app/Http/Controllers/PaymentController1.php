<?php

namespace App\Http\Controllers;

use App\Helpers\cart\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use PayPing\PayPingException;

class PaymentController1 extends Controller
{
    /**
     * @return Application|RedirectResponse|Redirector
     * @throws PayPingException
     * description: انتقال به درگاه پرداخت اینترنتی
     */

    public function payment(){
        $carts = Cart::all();
        $res_number = Str::random();

       if($carts->count()!= 0){
           $price = $carts->sum(function($cart){
               return $cart['price'] * $cart['quantity'];
           });

            $order = auth()->user()->orders()->create([
                'price'=>$price,
                'status'=>'unpaid',
            ]);

            $carts->each(function ($cart) use ($order) {
                $cart["product"]->orders()->attach($order->id,['quantity'=>$cart["quantity"]]);
            });

           $token = config("services.payping.token");
           $args = [
                "amount" =>100,
                "payerName" => auth()->user()->name,
                "returnUrl" => route('payment.callback'),
                "clientRefId" => $res_number,
           ];

           $payment = new \PayPing\Payment($token);

            $order->payments()->create([
               "price"=>$price,
               'res_number'=>$res_number,
           ]);

           Cart::flush();

           try {
                $payment->pay($args);
           } catch (\Exception $e) {
                throw $e;
           }
            //echo $payment->getPayUrl();
           return redirect($payment->getPayUrl());
       }

       alert()->error("your cart is empty")->closeOnClickOutside();
       return back();
    }


    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * description: انجام یا عدم انجام پرداخت اینترتی
     */

    public function paymentCallback(Request $request){
        $token = config("services.payping.token");
        $payping = Payment::where('res_number',$request->clientrefid)->firstOrFail();
        $payment = new \PayPing\Payment($token);

        try {
            if($payment->verify($request->refid, 100)){
                $payping->update([
                   "status"=>1,
                ]);
                $payping->order()->update([
                    "status"=>"paid"
                ]);
                alert()->success("پرداخت شما با موفقبت انجام شد","تراکنش موفق")->closeOnClickOutside();
                return redirect("/products");
            }else{
                alert()->error("متاسفانه پرداخت با موقفقیت انجام نشد","تراکنش ناموفق")->closeOnClickOutside();
                return redirect("/products");
            }
        }
        catch (\Exception $e) {
            $errors = collect(json_decode($e->getMessage() , true));
            alert()->error($errors->first());
            return redirect('/products');
        }
    }

}
