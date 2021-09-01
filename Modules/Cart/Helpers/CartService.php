<?php

namespace Modules\Cart\Helpers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Discount\Entities\Discount;

class CartService
{

    protected $cartCollection;
    protected $cartSession;
    protected $sessionId;

    /**
     * building our cart based on sessions
     */
    public function __construct(){
        $this->cartCollection = session()->get('cart') ?? collect([]);
    }

    /**
     * update quantity of card if key is a number
     * and specific params if key is an array
     *
     *
     * @param $key
     * @param $option
     * @return $this
     */
    public function updateQuantity($key,$option): CartService
    {
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

    /**
     * put a product in a Cart and Update it
     *
     * @param array $cartValues
     * @param null $obj
     */

    public function put(array $cartValues, $obj=null){

        if($obj instanceof Model){
            $value = array_merge([
                "id"=> Str::random(10),
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

    /**
     * check a product existence in a cart
     *
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {

        if($key instanceof Model) {
            return !is_null(
                $this->cartCollection->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first()
            );
        }

        return !is_null(
            $this->cartCollection->firstWhere("id",$key)
        );
    }


    /**
     * changing the cart in a better collection
     *
     * @param $item
     * @return array|mixed
     */
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

    /**
     * getting a specific item in cart according to id or the product object
     * @param $key
     * @param bool $withRelationShip
     * @return array|mixed
     */
    public function get($key, bool $withRelationShip=true){
        if($key instanceof Model){
            $item =  $this->cartCollection->where('subject_id',$key->id)->where('subject_type',get_class($key))->first();
            return $withRelationShip==true ? $this->withRelationship($item) : $item;
        }

        $item =  $this->cartCollection->firstWhere('id',$key);
        return $withRelationShip==true ? $this->withRelationship($item) : $item;
    }


    /**
     * getting all the items in cart
     *
     * @param bool $withRelationShip
     * @return Collection
     */
    public function all(bool $withRelationShip = true): Collection
    {
        return $this->cartCollection->map(function ($item) use ($withRelationShip) {
            return $withRelationShip==true ? $this->withRelationship($item) : $item;
        });
    }

    /**
     * counting the quantity of a product in cart
     * @param $obj
     * @return int
     */
    public function count($obj): int
    {
        $item = $this->get($obj,false);

        if(isset($item["quantity"])){
            return (int) $item["quantity"] ;
        }else{
            return 0;
        }
    }

    /**
     * deleting a specific product from cart
     * @param $key
     */
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

    /**
     * flush the cart
     */
    public function flush()
    {
        $carts = $this->all();
        $carts->each(function ($cart){
            session("cart")->forget($cart["id"]);
        });
    }

    /**
     * add discount to our cart structure
     *
     * @param Discount $discount
     * @return $this
     */
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

    /**
     * check the discount in the cart
     * @return bool
     */
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

    /**
     * access to the executed discount
     *
     * @return mixed
     */
    public function getDiscount(){

        $products = $this->all()->pluck("product");

        $disProduct = $products->sole(function ($product){
            return $product->discounts->isNotEmpty();
        });

        return $disProduct->discounts->first();

    }

    /**
     * remove discount from the cart
     *
     * @return $this
     */
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
