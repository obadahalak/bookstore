<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auther extends Model
{
    use HasFactory;

    public $guarded = [];


    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function books(){
        return $this->hasMany(Book::class);
    }
}
