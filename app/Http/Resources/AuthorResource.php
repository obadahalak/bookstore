<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->resource !==null){

            return [
            'id'=>$this->id,
            'name'=>$this->name,
            'bio'=>$this->bio,
            'type'=>$this->type ,
            'countOfBooks'=>$this->count_of_books,
            'image'=>$this->getImage(),
            'books'=>BookResource::collection($this->whenLoaded('books')),
        ];
    }
        return abort(422,'aurhor not found');
    }
}
