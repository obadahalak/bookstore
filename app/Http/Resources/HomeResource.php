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
                [
                    'id' => 1,
                    'tagName' => 'NEW BOOKS',
                    'books' => [
                        'id' => $this->id,
                        'name' => $this->name,
                        'details' => $this->details,
                        'image' => $this->coverImage->file,
                    ]
                ],
                [
                    'id' => 2,
                    'tagName' => 'TOP RATING',
                    'books' => [
                        'id' => $this->id,
                        'name' => $this->name,
                        'details' => $this->details,
                        'image' => $this->coverImage->file,
                    ]
                ],

            ]

        ];
    }
}
