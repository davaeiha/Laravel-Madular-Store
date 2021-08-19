<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\CategoryProduct\Entities\Product;

class ProductGallery extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table='product_galleries';

    /**
     * @var string[]
     */
    protected $fillable=[
        'image',
        'alt',
    ];

    /**
     * access the product of a gallery
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

//    /**
//     * download
//     *
//     * @return MorphOne
//     */
//    public function download(): MorphOne
//    {
//        return $this->morphOne(Download::class,"downloadable");
//    }

//
//    /**
//     * @return mixed|string
//     */
//    public function getFile(){
//        $array = explode('/',$this->image);
//        $size = sizeof($array);
//        return $array[$size-1];
//    }
//
//    /**
//     * @return string
//     */
//    public function path(): string
//    {
//        $array = explode('/',$this->image);
//         array_shift($array);
//         array_pop($array);
//        return implode('/',$array);
//    }

}
