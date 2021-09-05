<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
                'email'=>$this->email,
                'type'=>$this->type,
                'phone_number'=>$this->phone_number,
            ],
        ];
    }
}
