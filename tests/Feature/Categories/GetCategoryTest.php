<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;


class GetCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetListOfCategoriesWithoutAuth()
    {
        $response = $this->get('/categories');
        $response->assertStatus(302);
    }
    public function testGetListOfCategoriesWithAuth()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/categories');
        $response->assertOk();
    }
}
