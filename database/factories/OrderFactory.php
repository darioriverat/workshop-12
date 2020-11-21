<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Country;
use App\Enums\OrderStatus;
use App\Order;
use App\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            $user = User::inRandomOrder()->first();
            if(!$user) {
                $user = factory(User::class)->create();
            }
            return $user->id;
        },
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'status' => OrderStatus::CREATED,
        'quantity' => $faker->numerify('##'),
        'payment_amount' => $faker->numerify('########'),
        'country_id' => function() {
            $country = Country::inRandomOrder()->first();
            if (!$country) {
                $country = factory(Country::class)->create();
            }

            return $country->id;
        },
        'created_by' => function() {
            $user = User::inRandomOrder()->first();
            if(!$user) {
                $user = factory(User::class)->create();
            }
            return $user->id;
        }
    ];
});
