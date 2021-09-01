<?php

namespace Modules\OrderPayment\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\CategoryProduct\Entities\Product;


/**
 * @method static whereStatus(array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Request|string|null $request)
 * @property mixed products
 */
class Order extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "orders";

    /**
     * @var string[]
     */
    protected $fillable=[
        'user_id',
        'price',
        'status',
        'tracking_serial'
    ];

    /**
     * access the products of an order
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /**
     * access the user have been ordered
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * access the payments of an order
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }


}
