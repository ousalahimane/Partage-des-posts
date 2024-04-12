<?php

namespace App\Providers;

use App\Http\Controllers\PostTagController;
use App\Http\ViewComposers\ActivityComposer;
use App\Models\Comment;
use App\Models\Post;
use App\Observers\CommentObserver;
use App\Observers\PostObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', ActivityComposer::class);

        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);

        JsonResource::withoutWrapping();
    }
}
