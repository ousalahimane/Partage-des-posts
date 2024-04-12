<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $users = \App\Models\User::all();

      if($users->count() == 0){
         $this->command->info("Please create some users !");
         return;
      }

      \App\Models\Post::factory(30)->make()->each(function($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
       });

    }
}
