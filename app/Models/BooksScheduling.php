<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksScheduling extends Model
{
    use HasFactory;
    protected $table='books_schedulings';
    protected $guarded=[];
    protected $casts=[
        'days'=>'array'
    ];
    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    protected function user_id():Attribute{
        return Attribute::make(set:function(){
                return auth()->id();
        });
    }   
}
