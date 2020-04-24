<?php

namespace Tests\Feature;

use App\Categories;
use App\Products;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class DestroyProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreProductWithoutAuth()
    {
        
        // $this->get('/products', $product);
    }
    // public function testStoreProductWithAuth()
    // {
    //     try {
    //         Categories::insert('insert into categories (id,name, description) values (?, ?)', [999,1, 'Shoes']);
    //         $user = factory(User::class)->create();
    //         $product = factory(Products::class)->create();
    //         $product->category_id=999;
    //         $this->actingAs($user)->post('/products', $product);
    //         $this->assertTrue(true);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     } finally {
    //         Categories::destroy(999);
    //     }
    // }
    // public function testStoreProductWithAuthRemovingAttribute()
    // {
    //     try {
    //         $user = factory(User::class)->create();
    //         $product = factory(Products::class)->create();
    //         $product['name'] = '';
    //         $response = $this->actingAs($user)->post('/products', $product);
    //         echo $response->status;
    //     } catch (\Throwable $th) {
    //         $this->assertTrue(true);
    //         //throw $th;
    //     }
    // }
}
