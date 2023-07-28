<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $table='download_books';
    protected $guarded=[];

    protected function url ():Attribute{
        return  Attribute::make(
            set:function($value){
                return env('BOOK_URL') ."?token=".$value;
            }
        );
    }
}
