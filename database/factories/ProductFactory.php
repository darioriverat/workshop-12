<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->numerify('########'),
        'photo' => '',
        'currency' => (['COP', 'USD'][array_rand(['COP', 'USD'], 1)]),
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
    ];
});
