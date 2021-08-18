<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 */
class Attribute extends Model
{
    use HasFactory;
    protected $table = "attributes";
    protected $fillable = [
        "name"
    ];

   public function values(){
       return $this->hasMany(AttributeValue::class);
   }

   public function products(){
       return $this->belongsToMany(Product::class);
   }
}
