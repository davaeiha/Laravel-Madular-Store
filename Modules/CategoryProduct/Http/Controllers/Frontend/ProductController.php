<?php

namespace Modules\CategoryProduct\Http\Controllers\Frontend;



use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CategoryProduct\Entities\Product;

class ProductController extends Controller
{
    /**
     * show all the products
     *
     * @return Application|Factory|View
     */
    public function index(){
        $products = Product::all();
        return view("categoryproduct::products",compact("products"));
    }


    /**
     * show only one product
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function single(Product $product){
        return view("categoryproduct::single-product",["product"=>$product]);
    }
}
