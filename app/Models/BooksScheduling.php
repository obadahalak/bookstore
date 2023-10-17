<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksScheduling extends Model
{
    use HasFactory;
    protected $table = 'books_schedulings';
    
   public static $searchable=['id'];
    protected $guarded = [];

    public static function checkDurationTask($timeDuration)
    {
        $now = now()->format('m-d');

        return $now > $timeDuration->format('m-d') ? 'finished' : $timeDuration->longRelativeToOtherDiffForHumans();
    }

    protected static function booted(): void
    {
        static::addGlobalScope('my_books_schedulings', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }

    public function completedScope($q)
    {
        $q->where('status', true);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedulingInfos()
    {
        return $this->hasMany(SchedulingInfo::class);
    }
}
