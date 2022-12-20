<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    public $guards = [];


    public function coverImage()
    {
        return $this->morphOne(image::class, 'imageable');
    }
    public function images()
    {
        return $this->morphMany(image::class, 'imageable');
    }
}
