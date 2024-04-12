<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use Str;

class PostTest extends TestCase
{
    use RefreshDatabase;
    public function testSavePost(): void
    {

        $post = new Post();
        $post->title = 'new title to test';
        $post->slug = Str::slug($post->title,'-');
        $post->content = 'new content';
        $post->active = false;

        $post->save();

        $this->assertDatabaseHas('posts',[
            'title' => 'new title to test'
        ]);
    }

    public function testPostStoreValid(): void
    {
     
    $data = 
    [
        'title' => 'test our store post',
        'slug' => Str::slug('test our store post', '-'),
        'content' => 'content store',
        'active' => false
    ];

    $this->post('/posts', $data)
         ->assertStatus(302)
         ->assertSessionHas('status');

    $this->assertEquals(session('status'), 'post was created !!');
    
    }

    public function testPostStoreFail(): void
    {
     
    $data = 
    [
        'title' => '',
        'content' => ''
    ];

    $this->post('/posts', $data)
         ->assertStatus(302)
         ->assertSessionHas('errors');

    $messages = session('errors')->getMessages();
    $this->assertEquals($messages['title'][0], 'The title field is required.');
    $this->assertEquals($messages['content'][0], 'The content field is required.');
    
    }

    public function testPostUpdate(): void
    {

        $post = new Post();
        $post->title = 'second title to test';
        $post->slug = Str::slug($post->title,'-');
        $post->content = 'second content';
        $post->active = false;

        $post->save();

        $this->assertDatabaseHas('posts', $post->toArray());

        $data = 
        [
            'title' => 'test our updated post',
            'slug' => Str::slug('test our updated post', '-'),
            'content' => 'content updated',
            'active' => false
        ];
        
        $this->put("posts/{$post->id}", $data)
             ->assertStatus(302)
             ->assertSessionHas('status');

        $this->assertDatabaseHas('posts',[
            'title' => $data['title']
        ]);     

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title
        ]);

    }

    public function testPostDelete(): void
    {

        $post = new Post();
        $post->title = 'new title to test';
        $post->slug = Str::slug($post->title,'-');
        $post->content = 'new content';
        $post->active = false;

        $post->save();

        $this->assertDatabaseHas('posts', $post->toArray());

        $this->delete("posts/$post->id")
             ->assertStatus(302)
             ->assertSessionHas('status');

        $this->assertDatabaseMissing('posts', $post->toArray());
      
    }
}

    
