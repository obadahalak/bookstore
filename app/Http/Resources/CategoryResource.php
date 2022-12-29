<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->id,
            'tagId'=> $this->tag->id,
            'name' => $this->name,
            'title' => $this->name,
            'image' => $this->image->file,
            'description' => $this->description,
            'count_of_books' => $this->count_of_books,
        ];
    }
}
