<?php

namespace Modules\CategoryProduct\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Comment\Entities\Comment;
use Modules\Discount\Entities\Discount;
use Modules\Gallery\Entities\ProductGallery;
use Modules\OrderPayment\Entities\Order;
use Modules\User\Entities\User;

/**
 * @property mixed price
 * @method static where(string $string, string $string1, string $string2)
 * @method static latest()
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table="products";

    /**
     * @var string[]
     */
    protected $fillable=[
        'title',
        'description',
        'price',
        'inventory',
        'view_count',
        'user_id',
        'category_id',
        'image'
    ];

    /**
     * access the user of a product
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * access comments of a product
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class,"commentable");
    }

    /**
     * access the categories of a product
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * access the attributes of a product
     *
     * @return BelongsToMany
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    /**
     * access the values of a product
     *
     * @return BelongsToMany
     */
    public function values(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class);
    }


    /**
     * access the orders of a product
     *
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * access the images of a product
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductGallery::class);
    }


    /**
     * access the discounts of a product
     *
     * @return BelongsToMany
     */
    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }

}
