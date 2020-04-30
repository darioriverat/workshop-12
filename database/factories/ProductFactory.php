<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->numerify("########"),
        'photo' => $faker->imageUrl(),
        'currency' => 'COP',
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
    ];
});
