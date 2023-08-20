<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BooksScheduling extends Model
{
    use HasFactory;
    protected $table = 'books_schedulings';
    protected $guarded = [];
    protected $casts = [
        'days' => 'array'
    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted(): void
    {
        static::addGlobalScope('my_books_schedulings', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }

    public function days(): Attribute
    {
        return new Attribute(

            get: fn ($value) => json_decode($value)[0],
        );
    }
    public function checkDurationTaks($timeDuration)
    {
        $now = now()->format('m-d');

        return $now > $timeDuration->format('m-d') ?  'finished' : $timeDuration->longRelativeToOtherDiffForHumans();
    }
    public function completedScope($q){
        $q->where('status',true);
    }
}
