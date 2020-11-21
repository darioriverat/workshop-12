<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Country;
use App\Enums\CountryOptions;
use App\Enums\OrderStatus;
use App\Order;
use App\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
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
        'created_by' => factory(User::class)
    ];
});
