<?php

namespace Tests\Feature\Categories;

use App\Category;
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
        $category = ['name' => 'Shoes', 'description' => 'Tenis de salir'];
        $category = Category::create($category);
        $response = $this->delete('/categories/' . $category['id']);
        $response->assertStatus(302);
    }

    public function testDestroyCategoryWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
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
