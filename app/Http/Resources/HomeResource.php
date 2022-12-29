<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'tags' => [

                    'id' => 1,
                    'tagName' => 'NEW BOOKS',

            ],
            'id' => 2,
            'tagName' => 'NEW BOOKS',


        ];
    }
}
