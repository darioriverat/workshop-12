<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Currency;
use App\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => substr($faker->name, 0, 25),
        'description' => $faker->text,
        'price' => $faker->numerify('########'),
        'currency_id' => function() {
            $currency = Currency::inRandomOrder()->first();
            if (!$currency) {
                $currency = factory(Currency::class)->create();
            }

            return $currency->id;
        },
        'category_id' => factory(Category::class)->create(),
        'created_by' => function() {
            $user = User::inRandomOrder()->first();
            if(!$user) {
                $user = factory(User::class)->create();
            }
            return $user->id;
        }
    ];
});
