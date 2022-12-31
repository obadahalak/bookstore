<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }



    public function tag(){
        return $this->belongsTo(Tag::class);
    }

}
