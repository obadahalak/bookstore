<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;
    protected $table = 'user_activities';
    protected $guarded = [];

    public static function getBooksCategories()
    {
        return self::with(['book:id,category_id' => ['category:id']])->get()->pluck('book.category.id')->unique()->toArray();
    }

    protected static function booted(): void
    {
        static::addGlobalScope('userActivity', function (Builder $builder) {
            $builder->where('user_id', auth()->id())->orderBy('count_of_visits', 'desc');
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
