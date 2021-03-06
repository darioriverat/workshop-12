<?php

namespace Tests\Feature;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testStoreOrdersWithoutAuth()
    {
        $order = factory(Order::class)->make()->toArray();
        $response = $this->post(route('orders.store', $order));
        $response->assertStatus(302);
    }

    /** @test */
    public function testStoreOrdersWithAuth()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->make()->toArray();
        $response = $this->actingAs($user)->post(route('orders.store', $order));
        $this->followRedirects($response)->assertOk();
    }

    /** @test */
    public function testStoreOrdersWithAuthRemovingAttriute()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->make()->toArray();
        $order['quantity'] = '';
        $response = $this->actingAs($user)->post(route('orders.store', $order));
        $response->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function testStoreOrdersWithAuthForeingsError()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->make()->toArray();
        $order['product_id'] = '455';
        $response = $this->actingAs($user)->post(route('orders.store', $order));
        $response->assertStatus(404);
    }
}
