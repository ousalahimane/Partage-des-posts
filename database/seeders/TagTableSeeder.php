<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = collect(['Travel', 'Science', 'Games', 'Cars', 'Books', 'News', 'Training']);

        $tags->each(function($tag){
            $myTag = new Tag();
            $myTag->name = $tag; 
            $myTag->save();
        });
    }
}
