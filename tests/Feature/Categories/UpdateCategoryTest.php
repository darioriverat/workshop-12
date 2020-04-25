<?php

namespace Tests\Feature;

use App\Categories;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testUpdateCategoryWithoutAuth()
    {
        $category = factory(Categories::class)->create();
        $category = ["id"=>$category->id,"name"=>"Shoes","description"=>"Cambio"];
        $response = $this->patch('/categories/'. $category['id'] ,$category);
        $response->assertStatus(302);
    }
    public function testUpdateCategoryWithAuth()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create()->toArray();
        $category["description"] ="cambio";
        $response = $this->actingAs($user)->patch('/categories/'. $category['id'] ,$category);
        $this->followRedirects($response)->assertOk();
    }
    public function testUpdateCategoryWithAuthRemovingAttribute()
    {
        $user = factory(User::class)->create();
        $category = factory(Categories::class)->create()->toArray(); 
        $category["description"] ="";
        $response = $this->actingAs($user)->patch('/categories/'. $category['id'],$category);
        $response->assertSessionHasErrors('description');
    }
}
