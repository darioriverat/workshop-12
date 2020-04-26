<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOrdersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetListOfOrdersWithoutAuth()
    {
        $response = $this->get('/orders');
        $response->assertStatus(302);
    }
    public function testGetListOfOrdersWithAuth()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/orders');
        $response->assertOk();
    }
}
