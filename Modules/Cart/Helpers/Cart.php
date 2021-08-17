<?php namespace Modules\Cart\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Modules\Discount\Entities\Discount;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Class image
 * @package App\Helpers\cart
 * @method static Cart  put(array $cartValues,$obj)
 * @method static Boolean has($key);
 * @method static array get($key,$withRelationship);
 * @method static array all($withRelationship);
 * @method static array updateQuantity($obj,$option);
 * @method static Cart flush();
 * @method static Cart addDiscount($discount);
 * @method static Boolean isAllWithoutDiscount();
 * @method static Discount getDiscount();
 * @method static Cart removeDiscount();
 */
class Cart extends Facade
{
    /**
     * @return string
     *
     */

    protected static function getFacadeAccessor(): string
    {
        return "cart";
    }
}
