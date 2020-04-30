<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testStoreProductWithoutAuth()
    {
        $product = factory(Product::class)->make()->toArray();

        $response = $this->post(route('products.store'), $product);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function testStoreProductWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make()->toArray();

        $response = $this->actingAs($user)->post(route('products.store'), $product);

        $this->assertDatabaseHas('products', $product);
        $this->followRedirects($response)->assertOk();
    }

    /** @test */
    public function testStoreProductWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make()->toArray();
        $product['price'] = '';

        $response = $this->actingAs($user)->post(route('products.store'), $product);

        $response->assertSessionHasErrors('price');
    }

    /** @test */
    public function testStoreProductWithAuthDiferentOptionCurrency()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make()->toArray();
        $product['currency'] = 'aaa';

        $response = $this->actingAs($user)->post(route('products.store'), $product);

        $response->assertSessionHasErrors('currency');
    }

    /** @test */
    public function testStoreProductWithAuthWithoutproduct()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make()->toArray();
        $product['category_id'] = '';

        $response = $this->actingAs($user)->post(route('products.store'), $product);

        $response->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function testStoreProductWithAuthPriceValue()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make()->toArray();
        $product['price'] = 'aa';

        $response = $this->actingAs($user)->post(route('products.store'), $product);

        $response->assertSessionHasErrors('price');
    }
}
