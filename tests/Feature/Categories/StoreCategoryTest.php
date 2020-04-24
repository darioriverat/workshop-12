<?php

namespace Tests\Feature;

use App\Categories;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testStoreCategoryWithoutAuth()
    {
        $category = factory(Categories::class)->make()->toArray();
        $response = $this->post('/categories', $category);
        $response->assertStatus(302);
    }
    public function testStoreCategoryWithAuth()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->make()->toArray();
        $response = $this->actingAs($user)->post('/categories', $category);
        $this->followRedirects($response)->assertOk();
    }
    public function testStoreCategoryWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $category = ["name" => "Shoes"];
        $response = $this->actingAs($user)->post('/categories', $category);
        $response->assertSessionHasErrors('description');
    }
}
