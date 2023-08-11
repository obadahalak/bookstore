<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;
    protected $table = 'user_activities';
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope('userActivity', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
    public static function getBooksCategories()
    {
        $categories = self::with(['book.category'])->get()->pluck('book.category.id')->toArray();
        return ($categories);
    }
}
