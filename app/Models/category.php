<?php

namespace App\Models;

use App\Models\image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class category extends Model
{
    use HasFactory;

    public $guarded=[];

    public function image(){
        return $this->morphOne(image::class,'imageable');
    }
}
