<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->numberBetween(0,100000000),
        'photo' => $faker->imageUrl(),
        'category'=>$faker->numberBetween(0,100),
        '_token' => csrf_token()
    ];
});
