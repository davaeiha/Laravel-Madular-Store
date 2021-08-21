<?php

namespace Modules\OrderPayment\Http\Controllers\profile;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OrderPayment\Entities\Order;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;

/**
 * @method authorize(string $string, Order $order)
 */
class OrderController extends Controller
{
    /**
     * show all the orders that user has made
     *
     * @return Application|Factory|View
     */
    public function index(){
        $orders = auth()->user()->orders()->latest('created_at')->paginate(10) ;
        return view('orderpayment::profile.orders',compact('orders'));
    }

    /**
     * shows the details of the order
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function showDetails(Order $order){
        return view('orderpayment::profile.orderDetails',compact('order'));
    }

    /**
     * deciding to pay an unpaid order
     *
     * @param Order $order
     * @return mixed
     * @throws \Exception
     */
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
