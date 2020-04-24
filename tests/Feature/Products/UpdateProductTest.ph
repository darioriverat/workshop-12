<?php

namespace Tests\Feature;

use App\Categories;
use App\Products;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;


class UpdateProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testStoreProductWithoutAuth()
    {
        $category = factory(Categories::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product["category_id"]=$category->id;
        $response = $this->post('/products', $product);
        $response->assertStatus(302);
    }
    public function testStoreProductWithAuth()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product["category_id"]=$category->id;
        $response = $this->actingAs($user)->post('/products', $product);
        $this->followRedirects($response)->assertOk();
    }
    public function testStoreProductWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product["category_id"]=$category->id;
        $product["price"]="";
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('price');
    }
    public function testStoreProductWithAuthDiferentOptionCurrency()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create();
        $product = factory(Products::class)->make()->toArray();
        $product["category_id"]=$category->id;
        $product["currency"]="aaa";
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('currency');
    }
    public function testStoreProductWithAuthWithoutCategory()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->make();
        $product = factory(Products::class)->make()->toArray();
        $product["category_id"]=$category->id;
        $response = $this->actingAs($user)->post('/products', $product);
        $response->assertSessionHasErrors('category_id');
    }
}
