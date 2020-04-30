<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testUpdateProductWithoutAuth()
    {
        $product = factory(Product::class)->create()->toArray();
        $product['name'] = 'cambios';

        $response = $this->patch(route('products.update', $product['id']), $product);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function testUpdateProductWithAuth()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product['name'] = 'cambios';

        $response = $this->actingAs($user)->patch(route('products.update', $product['id']), $product);

        $this->followRedirects($response)->assertOk();
    }

    /** @test */
    public function testUpdateProductWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product['price'] = '';

        $response = $this->actingAs($user)->patch(route('products.update', $product['id']), $product);

        $response->assertSessionHasErrors('price');
    }

    /** @test */
    public function testUpdateProductWithAuthInvalidPrice()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product['price'] = 'aaa';

        $response = $this->actingAs($user)->patch(route('products.update', $product['id']), $product);

        $response->assertSessionHasErrors('price');
    }

    /** @test */
    public function testUpdateProductWithAuthDiferentOptionCurrency()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product['currency'] = 'aaa';

        $response = $this->actingAs($user)->patch(route('products.update', $product['id']), $product);

        $response->assertSessionHasErrors('currency');
    }

    /** @test */
    public function testUpdateProductWithAuthWithoutCategory()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product['category_id'] = '';

        $response = $this->actingAs($user)->patch(route('products.update', $product['id']), $product);

        $response->assertSessionHasErrors('category_id');
    }
}
