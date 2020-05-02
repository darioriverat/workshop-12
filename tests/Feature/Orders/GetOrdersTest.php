<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testGetListOfOrdersWithoutAuth()
    {
        $response = $this->get(route('orders.index'));
        $response->assertRedirect('login');
    }

    /** @test */
    public function testGetListOfOrdersWithAuth()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('orders.index'));
        $response->assertOk();
    }
}
