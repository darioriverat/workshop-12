<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->numerify("########"),
        'photo' => $faker->imageUrl(),
        'category_id'=>$faker->numberBetween(0, 100),
        'currency' => 'COP'
    ];
});
