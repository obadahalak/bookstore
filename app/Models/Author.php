<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Image;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Authenticatable
{
    use  HasFactory;
    public $guarded = [];


    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function books(){
        return $this->hasMany(Book::class,'Author_id');
    }

    public function myBooks(){
        return $this->hasMany(Book::class);
    }

    public function password(): Attribute
    {
        return new Attribute(
            set: fn ($value) =>Hash::make($value),
        );
    }
}
