<?php

namespace Modules\CategoryProduct\Http\Controllers\Api\v1\Frontend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CategoryProduct\Entities\Product;
use Modules\CategoryProduct\Transformers\Api\v1\ProductCollection;
use Modules\CategoryProduct\Transformers\Api\v1\Product as ProductResource;

class ProductController extends Controller
{

    /**
     * retrieving all products in Api service
     *
     * @return ProductCollection
     */
   public function index(): ProductCollection
   {
        $products = Product::paginate(4);
        return new ProductCollection($products);
   }

    /**
     * retrieving one product in Api service
     *
     * @param Product $product
     * @return ProductResource
     */
   public function single(Product $product): ProductResource
   {
        return new ProductResource($product);
   }
}
