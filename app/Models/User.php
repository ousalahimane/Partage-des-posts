<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const LOCALES = [
        'ar' => 'Arabic',
        'en' => 'English',
        'fr' => 'French'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function comments()
    {
       return $this->morphMany(Comment::class, 'commentable')->dernier();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function scopeManyPosts(Builder $query){
        return $query->withCount('posts')->orderBy('posts_count', 'desc');
   }
   
   public function scopeUserActiveInLastMonth(Builder $query){
    return $query->withCount(['posts' => function(Builder $query){
           $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
    }])
    ->having('posts_count', '>', 32)
    ->orderBy('posts_count', 'desc');
}

}
