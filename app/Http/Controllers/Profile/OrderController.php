<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\cart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;

class OrderController extends Controller
{
    public function index(){
        $orders = auth()->user()->orders()->latest('created_at')->paginate(10) ;
        return view('profile.orders',compact('orders'));
    }

    public function showDetails(Order $order){
        $this->authorize('view',$order);
        return view('profile.orderDetails',compact('order'));
    }

    public function payment(Order $order){


        //$order->price
        $invoice = (new Invoice)->amount(100);
        // Purchase and pay the given invoice.
        // You should use return statement to redirect user to the bank page.
        return ShetabitPayment::callbackUrl(route("payment.callback"))->purchase($invoice, function($driver, $transactionId) use ($invoice,  $order) {
            // Store transactionId in database as we need it to verify payment in the future.
            $order->payments()->create([
                "price"=>$order->price,
                'res_number'=>$invoice->getUuid(),
            ]);

        })->pay()->render();
    }
}
