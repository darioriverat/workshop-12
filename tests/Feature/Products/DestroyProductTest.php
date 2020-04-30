<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testDestroyProductsWithoutAuth()
    {
        $product = factory(Product::class)->create();
        $response = $this->delete('/products/' . $product['id']);
        $response->assertStatus(302);
    }

    public function testDestroyProductsWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $response = $this->actingAs($user)->delete('/products/' . $product->id);
        $this->followRedirects($response)->assertOk();
    }

    public function testDestroyProductsWithAuthErrorId()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->delete('/products/' . 10000000);
        $response->assertStatus(404);
    }
}
