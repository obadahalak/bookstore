<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data=[
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'bio'=>$this->bio,
           
            'image'=>$this->getImage(),
        ];
        if(auth()->user()->tokenCan('Author')){
              
            $data=array_merge($data,[
                'Author_type'=>$this->type,
                'count_books'=>$this->books,
            ]);
        }
        return $data;
    }
}
