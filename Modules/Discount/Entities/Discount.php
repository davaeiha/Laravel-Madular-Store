<?php

namespace Modules\Discount\Entities;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\CategoryProduct\Entities\Category;
use Modules\CategoryProduct\Entities\Product;
use Modules\Discount\Database\factories\DiscountFactory;


/**
 * @method static where(string $string, mixed $code)
 * @method static latest()
 * @method static create(array $array)
 * @property mixed products
 * @property mixed code
 * @property mixed percent
 *
 */
class Discount extends Model
{
    use HasFactory;

    protected $table='discounts';

    protected $fillable = [
        'code',
        'occasion',
        'percent',
        'expired_at'
    ];



    protected static function newFactory()
    {
        return DiscountFactory::new();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
