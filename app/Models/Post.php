<?php

namespace App\Models;

use App\Models\Scopes\AdminShowDeleteScope;
use App\Models\Scopes\LatestScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'slug', 'active','user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function comments()
    {
       return $this->morphMany(Comment::class, 'commentable')->dernier();
    }
    
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeMostCommented(Builder $query) {
         return $query->withCount('comments')->orderBy('comments_count','desc');
    }

    public function scopePostWithUserCommentsTags(Builder $query){
         return $query->withCount('comments')->with(['user', 'tags']);
    }
    public static function boot(){
        
        static::addGlobalScope(new AdminShowDeleteScope);

        parent::boot();
        
        static::addGlobalScope(new LatestScope);

    }

}
