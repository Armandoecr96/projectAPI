<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'data' => [
                'type' => $this->type,
                'id' => $this->id,
                'attributes' => [
                    'name' => $this->name,
                    'price' => $this->price
                ],
                'links' => 'http://127.0.0.1:8000/api/products/'.$this->id
            ]
            
        ];
    }
}