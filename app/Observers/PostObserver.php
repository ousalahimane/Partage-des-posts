<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updating(Post $post): void
    {
        Cache::forget("post-show{$post->id}");
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleting(Post $post): void
    {
        $post->comments()->delete();
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restoring(Post $post): void
    {
        $post->comments()->restore();
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
