<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      
      if($this->command->confirm("Do you want to refresh your database ?", true)){
         $this->command->call("migrate:refresh");
         $this->command->info("Database was refreshed !");
      }

      $this->call([
        UsersTableSeeder::class, 
        PostsTableSeeder::class, 
        CommentsTableSeeder::class,
        TagTableSeeder::class,
        PostTagTableSeeder::class
    ]);
    
} 
}
