<?php

namespace Tests\Feature\Categories;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testStoreCategoryWithoutAuth()
    {
        $category = factory(Category::class)->make()->toArray();

        $response = $this->post(route('categories.store'), $category);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function testStoreCategoryWithAuth()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->make()->toArray();

        $response = $this->actingAs($user)->post(route('categories.store'), $category);

        $this->assertDatabaseHas('categories', $category);
        $this->followRedirects($response)->assertOk();
    }

    /** @test */
    public function testStoreCategoryWithAuthRemovingDescriptionAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->make()->toArray();
        $category['description'] = '';

        $response = $this->actingAs($user)->post(route('categories.store'), $category);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    public function testStoreCategoryWithAuthRemovingNameAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->make()->toArray();
        $category['name'] = '';

        $response = $this->actingAs($user)->post(route('categories.store'), $category);

        $response->assertSessionHasErrors('name');
    }
}
