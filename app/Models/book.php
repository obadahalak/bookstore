<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Auther;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $guards = [];


    public function coverImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type','cover');
    }
    public function Images()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type','gallary');
    }

    public function auther(){
        return $this->belongsTo(Auther::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
