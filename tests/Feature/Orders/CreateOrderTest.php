<?php

namespace Tests\Feature\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheCreationView()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();

        $response = $this->actingAs($user)
            ->get('orders/create/' . $product['id']);

        $response->assertOk();
    }

    /** @test */
    public function anUnauthorizedUserCannotAccessToTheCreationView()
    {
        $product = factory(Product::class)->create()->toArray();

        $response = $this
            ->get('orders/create/' . $product['id']);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();

        $response = $this->actingAs($user)
            ->get('orders/create/' . $product['id']);

        $response->assertSeeText(trans('orders.columns.description'));
        $response->assertSeeText(trans('orders.columns.price'));
        $response->assertSeeText(trans('orders.columns.paymentCountry'));
    }
}
