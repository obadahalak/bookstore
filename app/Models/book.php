<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    const ACTIVE = 1;
    
   public static $searchable=['id','name'];

    protected $guarded = [];

    public static function getCountPages($id)
    {
        return self::whereId($id)->first()->page_count;
    }

    public function scopeActive($q)
    {
        return $q->where('active', self::ACTIVE);
    }

    public function is_like()
    {
        return $this->likes->contains('user_id', auth()->id());
    }

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
        return $this->morphOne(Image::class, 'imageable')->where('type', 'cover');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'gallary');
    }

    public function bookFile()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'file');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
    
    public function evaluations()
    {
        return $this->belongsToMany(User::class, 'evaluations')->withTimestamps();
    }
}
