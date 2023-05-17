<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $guarded=[];

    public  static function AcceptanceMessage($book){
        $bookSlug= Str::slug($book);
        return "your Book $bookSlug has been published by admin";
    }
  
    
}
