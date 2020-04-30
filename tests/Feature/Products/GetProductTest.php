<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    /** @test */
    public function testGetListOfProductsWithoutAuth()
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function testGetListOfProductsWithAuth()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertOk();
    }
}
