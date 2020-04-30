<?php

namespace Tests\Feature\Products;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheCreationView()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('products.create'));

        $response->assertOk();
    }

    /** @test */
    public function anUnauthorizedUserCannotAccessToTheCreationView()
    {
        $response = $this
            ->get(route('products.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('products.create'));

        $response->assertSeeText(trans('products.columns.name'));
        $response->assertSeeText(trans('products.columns.description'));
        $response->assertSeeText(trans('products.columns.currency'));
        $response->assertSeeText(trans('products.columns.price'));
        $response->assertSeeText(trans('actions.create.action'));
    }
}
