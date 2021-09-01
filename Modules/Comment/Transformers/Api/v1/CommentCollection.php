<?php

namespace Modules\Comment\Transformers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
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
            'data'=>$this->collection->map(function ($comment){
                return [
                    'comment'=>$comment->comment,
                    'parent_id'=>$comment->parent_id,
                    'publish'=>$comment->publish
                ];
            })
        ];
    }
}
