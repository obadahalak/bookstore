<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BookHomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'details' => $this->details,
            'image' => $this->coverImage->file,
        ];
    }
}
