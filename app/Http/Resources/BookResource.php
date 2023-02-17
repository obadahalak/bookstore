<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->routeIs('myBooks')) {

            return [
                'id' => $this->id,
                'name' => $this->name,
                'details' => $this->details,
                'overview' => $this->overview,
                'rate' => $this->rating,
                'category' => $this->category->name,
                'coverImage' => $this->coverImage->file ?? null,
                'gallaryImage' => GallaryImagesResurce::collection($this->Images),
                'category_name' =>'https://aurora-team.com/bookStore'.$this->category->name,
            ];
        }
        // }
        return [

            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'overview' => $this->overview,
            'rate' => $this->rating,
            'auther' => $this->auther->name,
            'category' => $this->category->name,
            'coverImage' => $this->coverImage->file ?? null,
            'gallaryImage' => GallaryImagesResurce::collection($this->Images),
            'category_name' => $this->category->name,

        ];
    }
}
