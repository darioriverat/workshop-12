<?php

namespace Tests\Feature;

use App\Orders;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreOrdersTest extends TestCase
{
    
    use RefreshDatabase;

    public function testStoreOrdersWithoutAuth()
    {
        $order = factory(Orders::class)->make()->toArray();
        $response = $this->post('/orders', $order);
        $response->assertStatus(302);
    }
    public function testStoreOrdersWithAuth()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $order = factory(Orders::class)->make()->toArray();
        $response = $this->actingAs($user)->post('/orders', $order);
        $this->followRedirects($response)->assertOk();
    }
    public function testStoreOrdersWithAuthRemovingAttriute()
    {
        $user = factory(User::class)->create();
        $order = factory(Orders::class)->make()->toArray();
        $order["quantity"]="";
        $response = $this->actingAs($user)->post('/orders', $order);
        $response->assertSessionHasErrors('quantity');
    }
    public function testStoreOrdersWithAuthForeingsError()
    {
        $user = factory(User::class)->create();
        $order = factory(Orders::class)->make()->toArray();
        $order["product_id"]="455";
        $response = $this->actingAs($user)->post('/orders', $order);
        $response->assertStatus(404);
    }
}
