<?php

namespace Modules\Comment\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
                'commentable_id'=>$this->commentable_id,
                'commentable_type'=>$this->commentable_type,
                'comment'=>$this->comment,
                'parent_id'=>$this->parent_id,
                'publish'=>jdate($this->created_at)->ago()
            ]
        ];
    }
}
