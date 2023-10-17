<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function AcceptanceMessage($book)
    {
        $bookSlug = Str::slug($book);

        return "your Book {$bookSlug} has been published by admin";
    }
}
