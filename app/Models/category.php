<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory ,  \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $guarded = [];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
