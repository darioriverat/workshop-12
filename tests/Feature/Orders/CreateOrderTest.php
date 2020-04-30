<?php

namespace Tests\Feature\Products;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheCreationView()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('orders.create'));

        $response->assertOk();
    }

    /** @test */
    public function anUnauthorizedUserCannotAccessToTheCreationView()
    {
        $response = $this
            ->get(route('orders.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('orders.create'));

        $response->assertSeeText(trans('orders.columns.name'));
        $response->assertSeeText(trans('orders.columns.description'));
        $response->assertSeeText(trans('orders.columns.currency'));
        $response->assertSeeText(trans('orders.columns.price'));
        $response->assertSeeText(trans('actions.create.action'));
    }
}
