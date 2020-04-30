<?php

namespace Tests\Feature\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheEditView()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();

        $response = $this->actingAs($user)
            ->get(route('products.edit', $product['id']));

        $response->assertOk();
    }

    /** @test */
    public function anUnauthorizedUserCannotAccessToTheEditView()
    {
        $product = factory(Product::class)->create()->toArray();

        $response = $this
            ->get(route('products.edit', $product['id']));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();

        $response = $this->actingAs($user)
            ->get(route('products.edit', $product['id']));

        $response->assertSeeText(trans('products.columns.name'));
        $response->assertSeeText(trans('products.columns.description'));
        $response->assertSeeText(trans('products.columns.currency'));
        $response->assertSeeText(trans('products.columns.price'));
        $response->assertSeeText(trans('actions.edit.action'));
    }
}
