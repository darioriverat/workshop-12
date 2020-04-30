<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;


class GetCategoryTest extends TestCase
{
    /** @test */
    public function testGetListOfCategoriesWithoutAuth()
    {
        $response = $this->get(route('categories.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function testGetListOfCategoriesWithAuth()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertOk();
    }
}
