<?php

namespace Tests\Feature;

use App\Categories;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;



class StoreCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testStoreCategoryWithoutAuth()
    {
        $category = factory(Categories::class)->create();
        $response = $this->post('/categories', $category);
        $response->assertStatus(302);
    }
    public function testStoreCategoryWithAuth()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create();
        $response = $this->actingAs($user)->post('/categories', [$category, "_token" => csrf_token()]);
        $response->assertOk();
    }
    public function testStoreCategoryWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create();
        $category->name = '';
        $response = $this->actingAs($user)->post('/categories', $category);
        // $response
    }
}
