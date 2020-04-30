<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UpdateProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testUpdateProductWithoutAuth()
    {
        $product = factory(Product::class)->create()->toArray();
        $product["name"] = "cambios";
        $response = $this->patch('/products/' . $product['id'], $product);
        $response->assertStatus(302);
    }
    public function testUpdateProductWithAuth()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product["name"] = "cambios";
        $response = $this->actingAs($user)->patch('/products/' . $product['id'], $product);
        $this->followRedirects($response)->assertOk();
    }
    public function testUpdateProductWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product["price"]="";
        $response = $this->actingAs($user)->patch('/products/' . $product['id'], $product);
        $response->assertSessionHasErrors('price');
    }
    public function testUpdateProductWithAuthInvalidPrice()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product["price"]="aaa";
        $response = $this->actingAs($user)->patch('/products/' . $product['id'], $product);
        $response->assertSessionHasErrors('price');
    }
    public function testUpdateProductWithAuthDiferentOptionCurrency()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product["currency"]="aaa";
        $response = $this->actingAs($user)->patch('/products/' . $product['id'], $product);
        $response->assertSessionHasErrors('currency');
    }
    public function testUpdateProductWithAuthWithoutCategory()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product["category_id"]="";
        $response = $this->actingAs($user)->patch('/products/' . $product['id'], $product);
        $response->assertSessionHasErrors('category_id');
    }
    public function testUpdateProductWithAuthWithoutForeignCategory()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create()->toArray();
        $product["category_id"]="959595";
        $response = $this->actingAs($user)->patch('/products/' . $product['id'], $product);
        $response->assertSessionHasErrors('missingFields');
    }
}
