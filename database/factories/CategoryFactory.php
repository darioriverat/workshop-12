<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categories;
use Carbon\Traits\Timestamp;
use Faker\Generator as Faker;

$factory->define(Categories::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text
    ];
});
