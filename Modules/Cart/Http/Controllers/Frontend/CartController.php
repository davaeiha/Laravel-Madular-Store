<?php

namespace Modules\Cart\Http\Controllers\Frontend;


use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Cart\Helpers\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart(){

        return view('cart::cart');
    }

    public function addToCart(Product $product): RedirectResponse
    {


        if(Cart::has($product)){
            Cart::updateQuantity($product,1);
        }else{
            Cart::put([
                "price"=>$product->price,
                "quantity"=>1,
            ],$product);
        }

        return back();

    }

    public function removeCart($id): RedirectResponse
    {
        Cart::delete($id);

        return back();
    }

    public function changeQuantity(Request $request){

//        if($request->ajax() && $request->isMethod('patch')){
//

//        }
        $data = $request->validate([
            "id"=>"required",
            "quantity"=>"required",
//            "cart"=>"required"
        ]);

//        if($data["quantity"]<image::get($data["id"])["product"]->inventory)m{
            if(Cart::has($data["id"])){
                Cart::updateQuantity($data['id'],[
                    "quantity"=>$data['quantity']
                ]);

                return response(["status"=>"success"],200);
            }
//        }

        return response(["status"=>"error"],404);
    }





}
