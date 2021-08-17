<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Discount\Entities\Discount;

class Category extends Model
{
    use HasFactory;
    protected $table="categories";

    protected $fillable=[
        "name",
        "parent_id"
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }

}
