<?php

namespace Tests\Feature;

use App\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public $route = '/categories/';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreCategories()
    {
        $this->withoutMiddleware();
        $category = factory(Categories::class)->create();
        $response = $this->post($this->route, [$category]);
        $response->assertStatus(200);
    }
    public function testGetCategories()
    {
        $this->withoutMiddleware();
        $response = $this->get($this->route);
        $response->assertStatus(200);
    }
    public function testUpdateCategories()
    {
        $this->withoutMiddleware();
        $response = $this->patch($this->route.'1', ['_token' => csrf_token()]);
        $response->assertStatus(200);
    }
    public function testDestroyCategories()
    {
        $this->withoutMiddleware();
        $response = $this->patch($this->route.'1', ['_token' => csrf_token()]);
        $response->assertStatus(200);
    }
}
