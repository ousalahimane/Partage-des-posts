<?php 

namespace App\Http\ViewComposers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer {

   public function compose(View $view){
        
        $mostCommented = Cache::remember('mostCommented', now()->addSeconds(10), function() {
            return Post::mostCommented()->take(5)->get();
        });

        $manyPosts = Cache::remember('manyPosts', now()->addSeconds(10), function() {
            return User::manyPosts()->take(5)->get();
        });

        $activeInLastMonth = Cache::remember('activeInLastMonth', now()->addSeconds(10), function() {
            return User::UserActiveInLastMonth()->take(5)->get();
        });

        $view->with([
            'mostCommented' => $mostCommented,
            'manyPosts' => $manyPosts,
            'activeInLastMonth' => $activeInLastMonth
        ]);
   }
}

