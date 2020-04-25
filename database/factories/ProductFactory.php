<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categories;
use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->numerify("########"),
        'photo' => $faker->imageUrl(),
        'currency' => 'COP',
        'category_id' => function(){
            return factory(Categories::class)->create()->id;
        },
    ];
});
