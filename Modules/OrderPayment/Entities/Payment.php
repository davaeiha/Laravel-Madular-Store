<?php

namespace Modules\OrderPayment\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, mixed $clientrefid)
 */
class Payment extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table='payments';

    /**
     * @var string[]
     */
    protected $fillable=[
        'status',
        'res_number',
        'price',
    ];

    /**
     * access the order of a payment
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


}
