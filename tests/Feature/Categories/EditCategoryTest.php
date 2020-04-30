<?php

namespace Tests\Feature\Categories;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheEditView()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create()->toArray();

        $response = $this->actingAs($user)->get(route('categories.edit', $category['id']));

        $response->assertOk();
    }

    /** @test */
    public function anUnauthorizedUserCannotAccessToTheEditView()
    {
        $category = factory(Category::class)->create()->toArray();

        $response = $this->get(route('categories.edit', $category['id']));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create()->toArray();

        $response = $this->actingAs($user)->get(route('categories.edit', $category['id']));

        $response->assertSeeText(trans('categories.columns.name'));
        $response->assertSeeText(trans('categories.columns.description'));
        $response->assertSeeText(trans('actions.edit.action'));
    }
}
