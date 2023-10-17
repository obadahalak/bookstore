<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles,  Notifiable;

    const VISITOR = 1;
    const Author = 2;

   public static $searchable=['id','name','email'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
        'password',
        'role',
        'type',
        'count_of_books',
        'rest_token',
        'reset_token_expiration',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function password(): Attribute
    {
        return new Attribute(

            set: fn ($value) => Hash::make($value),
        );
    }

    public function getImage()
    {
        return $this->image->file ?? $this->getDefaultImage();
    }

    public function scopeAuthor($q)
    {
        return $q->role('author');
    }

    public function withlistBooksid()
    {
        return $this->likes()->get()->pluck('id');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Book::class, 'likes')->withTimestamps();
    }

    public function evaluations()
    {
        return $this->belongsToMany(Book::class, 'evaluations')->withTimestamps();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function userActivities()
    {
        return $this->belongsToMany(Book::class, 'user_activities');
    }

    public function userBooksSchedulings($book_id)
    {
        return $this->belongsToMany(Book::class, 'books_schedulings')->where('book_id', $book_id)->exists();
    }

    public function booksSchedulings()
    {
        return $this->belongsToMany(Book::class, 'books_schedulings');
    }

    private function getDefaultImage()
    {
        return Storage::disk('public')->url('defaultImage.png');
    }
}
