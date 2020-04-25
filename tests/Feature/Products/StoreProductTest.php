<?php

namespace Tests\Feature;

use App\Products;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class StoreProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testStoreProductWithoutAuth()
    {
        $product = factory(Products::class)->make()->toArray();
        $response = $this->post('/products', $product);
        $response->assertStatus(302);
    }
    public function testStoreProductWithAuth()
    {
        $user = factory(User::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $response = $this->actingAs($user)->post('/products', $product);
        $this->followRedirects($response)->assertOk();
    }
    public function testStoreProductWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product["price"]="";
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('price');
    }
    public function testStoreProductWithAuthDiferentOptionCurrency()
    {
        $user = factory(User::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product["currency"]="aaa";
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('currency');
    }
    public function testStoreProductWithAuthWithoutCategory()
    {
        $user = factory(User::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product['category_id']="";
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('category_id');
    }
    public function testStoreProductWithAuthForeignErrorCategory()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product['category_id']="9595995";
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('missingFields');
    }
    public function testStoreProductWithAuthPriceValue()
    {
        $user = factory(User::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product['price']="aa";
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('price');
    }
}
