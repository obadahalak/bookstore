<?php
namespace App\Models\Relations;

use App\Models\Book;
use App\Models\BooksScheduling;
trait UserRelations
{



    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function  likes()
    {
        return $this->belongsToMany(Book::class, 'likes')->withTimestamps();
    }



    public function evaluations()
    {
        return  $this->belongsToMany(Book::class, 'evaluations')->withTimestamps();
    }

    public function booksSchedulings()
    {
        return $this->hasMany(BooksScheduling::class,'user_id','id');
    }
}
