<?php

namespace Tests\Feature;

use App\Categories;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testDestroyCategoryWithoutAuth()
    {
        $category = ["name" => "Shoes", "description" => "Tenis de salir"];
        $category = Categories::create($category);
        $response = $this->delete('/categories/' . $category['id']);
        $response->assertStatus(302);
    }
    public function testDestroyCategoryWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create();
        $response = $this->actingAs($user)->delete('/categories/' . $category->id);
        $this->followRedirects($response)->assertOk();
    }
    public function testDestroyCategoryWithAuthErrorId()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->delete('/categories/' . 10000000);
        $response->assertStatus(404);
    }
}
