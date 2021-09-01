<?php

namespace Modules\CategoryProduct\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\CategoryProduct\Entities\AttributeValue as Value;
class AttributeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request): array
    {
        $productValue=$request->product->attributes->map(function ($attr) {
            return Value::findOrFail($attr->pivot->value_id);
        });


        return [
            'data'=>$this->collection->map(function ($attr) use ($productValue) {
                return [
                    'name'=>$attr->name,
                    'value'=>new AttributeValue($attr->values->intersect($productValue)->first()),
                ];
            })
        ];
    }
}
