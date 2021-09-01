<?php

namespace Modules\CategoryProduct\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed name
 * @property mixed values
 */
class Attribute extends JsonResource
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
                'name'=>$this->name,
            ]
        ];
    }
}
