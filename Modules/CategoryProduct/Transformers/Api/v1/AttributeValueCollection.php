<?php

namespace Modules\CategoryProduct\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeValueCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request): array
    {
//        return parent::toArray($request);
        return $this->collection->toArray();
    }
}
