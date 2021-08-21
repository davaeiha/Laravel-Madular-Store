<?php

namespace Modules\Cart\Http\Controllers\Frontend;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cart\Helpers\Cart;
use Illuminate\Http\Request;
use Modules\CategoryProduct\Entities\Product;

class CartController extends Controller
{
    /**
     * show the Cart view for the customer
     * @return Application|Factory|View
     */
    public function showCart(){

        return view('cart::cart');
    }

    /**
     * adding a product to cart for the first time
     * and increase the number of the products for the second time
     *
     * @param Product $product
     * @return RedirectResponse
     */
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

    /**
     * remove a product from cart
     *
     * @param $id
     * @return RedirectResponse
     */

    public function removeCart($id): RedirectResponse
    {
        Cart::delete($id);
        return back();
    }

    /**
     * set number of product in cart
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */

    public function changeQuantity(Request $request){

        $data = $request->validate([
            "id"=>"required",
            "quantity"=>"required",
        ]);

        if(Cart::has($data["id"])){
            Cart::updateQuantity($data['id'],[
                "quantity"=>$data['quantity']
            ]);

            return response(["status"=>"success"],200);
        }

        return response(["status"=>"error"],404);
    }

}
