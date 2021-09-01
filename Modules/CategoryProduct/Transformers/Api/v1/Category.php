<?php

namespace Modules\CategoryProduct\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CategoryProduct\Entities\Category as CatMod;
/**
 * @property mixed name
 */
class Category extends JsonResource
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
                'parent'=>CatMod::where('id','parent_id')->value('name')
            ]
        ];
    }
}
