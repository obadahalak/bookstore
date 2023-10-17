<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Author extends Authenticatable
{
    use HasFactory;
    public $guarded = [];

    public function password(): Attribute
    {
        return new Attribute(
            set: fn ($value) => Hash::make($value),
        );
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'Author_id');
    }

    public function myBooks()
    {
        return $this->hasMany(Book::class);
    }
}
