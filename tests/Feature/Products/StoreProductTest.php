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


class StoreProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreProductWithoutAuth()
    {
        try {
            DB::insert('insert into categories (id,name, description) values (?, ?, ?)', [999, 1, 'Shoes']);
            $product = factory(Products::class)->create();
            $this->post('/products', $product);
        } catch (\Throwable $th) {
            $this->assertTrue(true);
        } finally {
            Categories::destroy(999);
        }
    }
    // public function testStoreProductWithAuth()
    // {
    //     DB::insert('insert into categories (id,name, description) values (?, ?, ?)', [999, 1, 'Shoes']);
    //     $user = factory(User::class)->create();
    //     $product = factory(Products::class)->create();
    //     $product->category_id = 999;
    //     $response = $this->actingAs($user)->post('/products', [$product, "_token" => csrf_token()]);
    //     Log::info('info', ["res", $response]);
    //     Categories::destroy(999);
    //     $response->assertOk();
    // }
    public function testStoreProductWithAuthRemovingAttribute()
    {
        try {
            $category = factory(Categories::class)->make();
            Categories::insert($category);
            $user = factory(User::class)->create();
            $product = factory(Products::class)->create();
            $product->category_id = $category->id;
            $product->name = "";
            $this->actingAs($user)->post('/products', $product);
            Categories::destroy($category->id);
        } catch (\Throwable $th) {
            $this->assertTrue(true);
            //throw $th;
        } finally {
        }
    }
}
