<?php

namespace Tests\Feature\Categories;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /*** @test */
    public function testUpdateCategoryWithoutAuth()
    {
        $category = factory(Category::class)->create()->toArray();

        $response = $this->put(route('categories.update', $category['id']), $category);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function testUpdateCategoryWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create()->toArray();
        $category['description'] = 'cambio';

        $response = $this->actingAs($user)->put(route('categories.update', $category['id']), $category);

        $this->assertDatabaseHas('categories', $category);
        $this->followRedirects($response)->assertOk();
    }

    /** @test */
    public function testUpdateCategoryWithAuthRemovingDescriptionAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create()->toArray();
        $category['description'] = '';

        $response = $this->actingAs($user)->put(route('categories.update', $category['id']), $category);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    public function testUpdateCategoryWithAuthRemovingNameAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create()->toArray();
        $category['name'] = '';

        $response = $this->actingAs($user)->put(route('categories.update', $category['id']), $category);

        $response->assertSessionHasErrors('name');
    }
}
