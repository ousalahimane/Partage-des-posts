<?php

namespace App\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['content', 'user_id'];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToToMany(Tag::class, 'taggable')->withTimestamps();
    }

    public function commentable() {

        return $this->morphTo();
    }
    
    public function scopeDernier(Builder $query){

        $query->orderBy(static::UPDATED_AT, 'desc');
    }
    public static function boot(){

        parent::boot();
        
        static::addGlobalScope(new LatestScope);

    }

}
