<?php

namespace Modules\OrderPayment\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Modules\Cart\Helpers\Cart;
use Modules\OrderPayment\Entities\Payment;
use Modules\OrderPayment\Events\Paid;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PaymentController extends Controller
{
    /**
     * making res_number
     * register order in database
     * register payment in database
     * go to payment port
     *
     * @throws \Exception
     */
    public function payment(){

        $carts = Cart::all();

        if($carts->count()){
            $price = $carts->sum(function($cart){
                return $cart['price'] * $cart['quantity'];
            });

            $order = auth()->user()->orders()->create([
                "status"=>"unpaid",
                "price"=>$price
            ]);

            $carts->each(function ($cart) use ($order) {
                $order->products()->attach($cart["product"]->id,['quantity'=>$cart["quantity"]]);
            });


            // Create new invoice.
//            $invoice = (new Invoice())->amount($price);
            $invoice = (new Invoice)->amount(100);
            // Purchase and pay the given invoice.
            // You should use return statement to redirect user to the bank page.
            return ShetabitPayment::callbackUrl(route("payment.callback"))->purchase($invoice, function($driver, $transactionId) use ($invoice, $price, $order) {
                // Store transactionId in database as we need it to verify payment in the future.
                $order->payments()->create([
                    "price"=>$price,
                    'res_number'=>$invoice->getUuid(),
                ]);

                Cart::flush();

            })->pay()->render();

        }

    }

    /**
     * callback url check:
     * if payment is successful or not
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function callback(Request $request){
        $paying = Payment::where('res_number',$request->clientrefid)->firstOrFail();

        try {
            //amount must be the price
//            $paying->order->price
            $receipt = ShetabitPayment::amount(100)->transactionId($request->clientrefid)->verify();

            // You can show payment referenceId to the user.
            $paying->update([
                "status"=>1,
            ]);

            $paying->order()->update([
                "status"=>"paid"
            ]);

            //dispatch event for notification
            event(new Paid($paying));

            alert()->success("پرداخت شما با موفقبت انجام شد","تراکنش موفق")->closeOnClickOutside();
            return redirect("/products");
//            echo $receipt->getReferenceId();


        } catch (InvalidPaymentException $exception) {
            /**
            when payment is not verified, it will throw an exception.
            We can catch the exception to handle invalid payments.
            getMessage method, returns a suitable message that can be used in user interface.
             **/
            alert()->error($exception->getMessage());
            return redirect("products");
        }
    }
}
