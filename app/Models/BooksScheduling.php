<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

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

    public function days(): Attribute
    {
        return new Attribute(

            get: fn ($value) => json_decode($value)[0],
        );
    }
    public function chechDurationTaks($timeDuration)
    {
        $now = now()->format('m-d');

        return $now > $timeDuration->format('m-d') ?  'finished' : $timeDuration->longRelativeToOtherDiffForHumans();
    }
}
