<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHomePage(): void
    {
        $response = $this->get('/home');

        $response->assertSeeText('home page');
        $response->assertSeeText('Life is beautiful !');
    }

    public function testAboutPage(): void
    {
        $response = $this->get('/about');

        $response->assertSeeText('about page');
    }
}
