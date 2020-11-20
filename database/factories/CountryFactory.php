<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Country;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Country::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->countryCode,
        'name' => $faker->country,
        'dial_codes' => [
            $faker->numberBetween(1, 9999),
        ],
        'numeric_code' => $faker->unique()->numberBetween(100, 999),
        'alpha_3_code' => $faker->unique()->countryISOAlpha3,
        'enabled_at' => $faker->dateTime,
    ];
});
