<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateOrdersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function testUpdateOrdersWithoutAuth()
    {
        $product = factory(Order::class)->make()->toArray();

        $response = $this->post('/products', $product);

        $response->assertStatus(302);
    }

    /** @test */
    public function testUpdateOrdersWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create()->toArray();

        $response = $this->actingAs($user)->put(route('orders.update', $order['id']));

        $order = Order::find($order['id']);

        $this->assertEquals(OrderStatus::PENDING, $order->status, true);
    }
}
