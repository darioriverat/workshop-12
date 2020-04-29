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

        $response->assertRedirect(route('login'));
    }

    public function testStoreCategoryWithAuth()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->make()->toArray();

        $response = $this->actingAs($user)->post('/categories', $category);

        $this->assertDatabaseHas('categories', $category);
        $this->followRedirects($response)->assertOk();
    }

    public function testStoreCategoryWithAuthRemovingDescriptionAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->make()->toArray();
        $category["description"]="";

        $response = $this->actingAs($user)->post('/categories', $category);

        $response->assertSessionHasErrors('description');
    }

    public function testStoreCategoryWithAuthRemovingNameAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->make()->toArray();
        $category["name"]="";

        $response = $this->actingAs($user)->post('/categories', $category);

        $response->assertSessionHasErrors('name');
    }
}
