<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Orders;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateOrdersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testUpdateProductWithoutAuth()
    {
        $product = factory(Orders::class)->make()->toArray();
        $response = $this->post('/products', $product);
        $response->assertStatus(302);
    }
    public function testUpdateProductWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $order = factory(Orders::class)->create()->toArray();
        $response = $this->actingAs($user)->patch('/orders/' . $order['id'], $order);
        $this->followRedirects($response)->assertOk();
    }
}
