<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = \App\Models\Post::all();
        $users = \App\Models\User::all();
           
        if($posts->count() == 0){
            $this->command->info("Please create some posts !");
            return;
         }

        \App\Models\Comment::factory(300)->make()->each(function($comment) use ($posts, $users) {
            $comment->post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
       });
    }
}
