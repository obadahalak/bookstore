<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Author;
use App\Models\Category;
use App\Models\Evaluation;
use App\enum\NotificationMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{

    use HasFactory  , \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $guarded= [];
    CONST  ACTIVE=1;


    public function coverBook()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function bookImages()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function coverImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type','cover');
    }
    public function Images()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type','gallary');
    }
    public function bookFile(){
        return $this->morphOne(Image::class, 'imageable')->where('type','file');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function  likes(){
        return $this->belongsToMany(User::class,'likes')->withTimestamps();
    }
    public function evaluations(){
     return $this->belongsToMany(User::class,'evaluations')->withTimestamps();
    }

    public function scopeActive($q){
        return $q->where('active',self::ACTIVE);
    }
    public function is_like(){
        return $this->likes->contains('user_id',auth()->id());
    }

}
