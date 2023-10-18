<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BookResource extends JsonResource
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
            'overview' => $this->overview,
            'rating' => $this->rating,
            'author' => $this->user->name,
            'category' => $this->category->title,
            'count_pages' => $this->page_count,
            'coverImage' => $this->coverImage->file,
            'gallaryImage' => GallaryImagesResource::collection($this->whenLoaded('images')),
            'book' => $this->bookFile->file,
            'is_like' => $this->isLike(),
            'similarBooks' => $this->additional,
            // 'existsInScheduling'=>auth()->user()->userBooksSchedulings($this->id)
        ];
    }
}
