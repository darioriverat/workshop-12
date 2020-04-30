<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Carbon\Traits\Timestamp;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text
    ];
});
