<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GallaryImagesResurce extends JsonResource
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
           'src'=>$this->file,
        ];
    }
}
