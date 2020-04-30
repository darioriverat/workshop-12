<?php

namespace Tests\Feature\Categories;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheCreationView()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('categories.create'));

        $response->assertOk();
    }

    /** @test */
    public function anUnauthorizedUserCannotAccessToTheCreationView()
    {
        $response = $this
            ->get(route('categories.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('categories.create'));

        $response->assertSeeText(trans('categories.columns.name'));
        $response->assertSeeText(trans('categories.columns.description'));
        $response->assertSeeText(trans('actions.create.action'));
    }
}
