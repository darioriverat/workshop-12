<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\CountryOptions;
use App\Orders;
use Faker\Generator as Faker;
use App\Enums\OrderStatus;
use App\Products;
use App\User;

$factory->define(Orders::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'product_id' => function(){
            return factory(Products::class)->create()->id;
        },
        'status' => OrderStatus::CREATED,
        'quantity' => $faker->numerify("##"),
        'paymentAmount' =>$faker->numerify("########"),
        'country' => CountryOptions::COLOMBIA,
        'processUrl' => $faker->url,
        'requestId' => $faker->numerify("########"),
    ];
});
