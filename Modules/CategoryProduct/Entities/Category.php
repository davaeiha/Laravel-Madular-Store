<?php

namespace Modules\CategoryProduct\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Discount\Entities\Discount;

/**
 * @method static where(string $string, int $int)
 * @method static create(array $array)
 * @method static find(array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Request|string|null $request)
 */
class Category extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table="categories";

    /**
     * @var string[]
     */
    protected $fillable=[
        "name",
        "parent_id"
    ];

    /**
     * access the products of a category
     * @function product
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * access the subgroups  of a category
     * @function child
     * @return HasMany
     */
    public function child(): HasMany
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    /**
     * access the discounts of a category
     *
     * @function discounts
     * @return BelongsToMany
     */
    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }

}
