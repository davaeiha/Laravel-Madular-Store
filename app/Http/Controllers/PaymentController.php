<?php

namespace App\Http\Controllers;

use App\Helpers\cart\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\In;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PaymentController extends Controller
{
    /**
     * @throws \Exception
     */
    public function payment(){

        $carts = Cart::all();

        if($carts->count()){
            $res_number = Str::random();
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

    public function callback(Request $request){
        $payping = Payment::where('res_number',$request->clientrefid)->firstOrFail();

        try {
            $receipt = ShetabitPayment::amount(100)->transactionId($request->clientrefid)->verify();

//            dd($receipt);

            // You can show payment referenceId to the user.
            $payping->update([
                "status"=>1,
            ]);

            $payping->order()->update([
                "status"=>"paid"
            ]);

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
