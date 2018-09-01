<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_name' => $this->name,
            'user_gender'=>$this->gender,
            'user_age'=> (String)$this->age,
            'user_share_with'=>$this->share_with
        ];
    }
}
