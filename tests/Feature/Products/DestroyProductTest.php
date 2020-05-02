<?php

namespace Tests\Feature\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyProductTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroyProductsWithoutAuth()
    {
        $product = factory(Product::class)->create();

        $response = $this->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('login'));
    }

    public function testDestroyProductsWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)->delete(route('products.destroy', $product->id));

        $this->assertSoftDeleted('products', $product->toArray());
        $this->followRedirects($response)->assertOk();
    }

    public function testDestroyProductsWithAuthErrorId()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->delete(route('products.destroy', 100000));

        $response->assertNotFound();
    }
}
