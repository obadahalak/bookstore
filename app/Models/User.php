<?php

namespace App\Models;


use App\Models\Relations\UserRelations;
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
    use HasApiTokens, HasFactory, Notifiable ,  HasRoles  ,UserRelations ;


    const VISITOR=1;
    const Author=2;
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
        'reset_token_expiration'
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


    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function getImage(){
        return $this->image->file ?? $this->getDefaultImage();
    }
    private function getDefaultImage(){
        return Storage::disk('public')->url('defaultImage.png');
    }
    public function scopeAuthor($q){
        return $q->role('author');
    }
    public function userActivities(){
        return $this->belongsToMany(Book::class,'user_activities');
    }
    public function withlistBooksid(){
        return $this->likes()->get()->pluck('id');
    }

    
}

