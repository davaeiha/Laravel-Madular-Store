<?php

namespace Modules\Cart\Helpers;

use App\Models\Product;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Modules\Discount\Entities\Discount;
use Psy\Util\Str;

class CartService
{

    protected $cartCollection;
    protected $cartSession;
    protected $sessionId;

    public function __construct(){
        $this->cartCollection = session()->get('cart') ?? collect([]);
    }

    public function getCartCollection(){
        return $this->cartCollection;
    }


    public function updateQuantity($key,$option){
        $item = $this->get($key,false);

        if(is_numeric($option)){
            $newQuantity = $item["quantity"] + $option;
            $updatedItem = array_merge($item,["quantity"=>$newQuantity]);
        }

        if(is_array($option)){
            $updatedItem = array_merge($item,$option);
        }

        $this->put($updatedItem);

        return $this;
    }


    public function put(array $cartValues, $obj=null){

        if($obj instanceof Model){
            $value = array_merge([
                "id"=> \Illuminate\Support\Str::random(10),
                "subject_id"=>$obj->id,
                "subject_type"=>get_class($obj),
                'discount_percentage'=>0,
            ],$cartValues);

        }else{
            $value = $cartValues;
        }

        $this->cartCollection->put($value["id"],$value);

        session()->put('cart',$this->cartCollection);
    }

    public function has($key){

        if($key instanceof Model) {
            return !is_null(
                $this->cartCollection->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first()
            );
        }

        return !is_null(
            $this->cartCollection->firstWhere("id",$key)
        );
    }

    protected function withRelationship($item){
        if(isset($item["subject_id"]) && isset($item["subject_type"])){
            $class = $item["subject_type"];
            $object = (new $class())->find($item["subject_id"]);
            $basename = strtolower(class_basename($class));

            $item = array_merge($item,[$basename => $object ]);

            unset($item["subject_id"]);
            unset($item["subject_type"]);

            return $item;
        }

        return $item;
    }


    public function get($key,$withRelationShip=true){
        if($key instanceof Model){
            $item =  $this->cartCollection->where('subject_id',$key->id)->where('subject_type',get_class($key))->first();
            return $withRelationShip==true ? $this->withRelationship($item) : $item;
        }

        $item =  $this->cartCollection->firstWhere('id',$key);
        return $withRelationShip==true ? $this->withRelationship($item) : $item;
    }

    public function all($withRelationShip = true){
        return $this->cartCollection->map(function ($item) use ($withRelationShip) {
            return $withRelationShip==true ? $this->withRelationship($item) : $item;
        });
    }

    public function count($obj){
        $item = $this->get($obj,false);

        if(isset($item["quantity"])){
            return (int) $item["quantity"] ;
        }else{
            return 0;
        }
    }

    public function delete($key){
        if($this->has($key)){
            $this->cartCollection = $this->cartCollection->filter(function ($item) use ($key) {
                if($key instanceof Model){
                    return ($item['subject_id'] != $key->id) && ($item['subject_type'] != get_class($key));
                }

                return $key != $item['id'];
            });

            session()->put('cart',$this->cartCollection);

        }
    }

    public function flush()
    {
        $carts = $this->all();
        $carts->each(function ($cart){
            session("cart")->forget($cart["id"]);
        });
    }

    public function addDiscount(Discount $discount): CartService
    {
            $percentage = $discount->percent;
            $discount->products->each(function ($product) use ($percentage) {
                if($this->has($product)){
                    $this->updateQuantity($product,[
                        "discount_percentage"=>$percentage,
                        'price'=>$product->price *(1 - $percentage/100),
                    ]);
                }
            });

        return $this;

    }

    public function isAllWithoutDiscount(): bool
    {
        if($this->all()->isNotEmpty()){
            return Cart::all()->every(function ($cart){
                return $cart["discount_percentage"] == 0;
            });
        }else{
            return true;
        }
    }

    public function getDiscount(){

        $products = $this->all()->pluck("product");

        $disProduct = $products->sole(function ($product){
            return $product->discounts->isNotEmpty();
        });

        return $disProduct->discounts->first();

    }

    public function removeDiscount(): CartService
    {
        $products = $this->getDiscount()->products;
        $products->each(function ($product){
            $this->updateQuantity($product,[
                'price'=> $product->price ,
                'discount_percentage'=>0 ,
            ]);
        });

        return $this;
    }
}
