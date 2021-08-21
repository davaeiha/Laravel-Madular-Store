<?php

namespace Modules\OrderPayment\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Modules\OrderPayment\Entities\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if($keyword = request("search")){
            $orders = Order::whereStatus(\request('type'))
                    ->where('id','like',"%$keyword%")
                    ->orWhere("user_id",'like',"%$keyword%")
                    ->orWhere('tracking_serial','like',"%$keyword%")
                    ->latest('created_at')
                    ->paginate(30);
        }else{
            $orders = Order::whereStatus(\request('type'))->latest()->paginate(30);
        }

        return view('orderpayment::admin.orders.all',['orders'=>$orders]);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order)
    {
        $products = $order->products;
        return \view('orderpayment::admin.orders.details',['products'=>$products,'order'=>$order]);
    }

    public function payments(Order $order){
        $payments = $order->payments()->latest()->paginate(15);
        return \view('orderpayment::admin.orders.payments',compact(['order','payments']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function edit(Order $order)
    {

        return \view("orderpayment::admin.orders.edit",compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            "status"=>['required',Rule::in(['unpaid','paid','preparation','posted','received','canceled'])],
            'tracking_serial'=>[Rule::unique('orders')->ignore($order->id),'nullable']
        ]);

        $order->update([
            'status'=>$data['status'],
            'tracking_serial'=>$data['tracking_serial'],
        ]);

        alert()->success('سفارش مورد نظر با موفقیت ویرایش شد');
        return redirect(route('admin.orders.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        alert()->success("سفارش مورد نظر با موفقیت حذف شد");
        return back();
    }
}
