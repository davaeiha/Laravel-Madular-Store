<?php

namespace Modules\CategoryProduct\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data'=>$this->collection->map(function ($product){
                return [
                    'title'=>$product->title,
                    'image'=>$product->image,
                    'inventory'=>$product->inventory
                ];
            })
        ];
    }
}
