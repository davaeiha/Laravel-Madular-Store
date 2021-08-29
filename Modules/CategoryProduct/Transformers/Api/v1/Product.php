<?php

namespace Modules\CategoryProduct\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed title
 * @property mixed description
 * @property mixed price
 * @property mixed view_count
 * @property mixed inventory
 * @property mixed image
 * @property mixed created_at
 * @property mixed categories
 * @property mixed attributes
 */
class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data'=>[
                'title'=>$this->title,
                'description'=>$this->description,
                'price'=>$this->price,
                'view_count'=>$this->view_count,
                'inventory'=>$this->inventory,
                'image'=>$this->image,
                'publish'=>jdate($this->created_at)->format('%B %d، %Y'),
                'categories'=>new CategoryCollection($this->categories),
                'attributes'=>new AttributeCollection($this->attributes)
            ]
        ];
    }
}
