<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProductGallery extends Model
{
    use HasFactory;

    protected $table='product_galleries';

    protected $fillable=[
        'image',
        'alt',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function download(): MorphOne
    {
        return $this->morphOne(Download::class,"downloadable");
    }

    public function getFile(){
        $array = explode('/',$this->image);
        $size = sizeof($array);
        return $array[$size-1];
    }

    public function path(){
        $array = explode('/',$this->image);
         array_shift($array);
         array_pop($array);
        return implode('/',$array);
    }

}
