<?php

namespace Modules\CategoryProduct\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(array $array)
 */
class Attribute extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "attributes";

    /**
     * @var string[]
     */
    protected $fillable = [
        "name"
    ];

    /**
     * accessing values of an attribute
     *
     * @return HasMany
     */
   public function values(): HasMany
   {
       return $this->hasMany(AttributeValue::class);
   }

    /**
     * accessing products of an attribute
     *
     * @return BelongsToMany
     */
   public function products(): BelongsToMany
   {
       return $this->belongsToMany(Product::class)->withPivot('value_id');
   }


}
