<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Currency;

use Faker\Generator as Faker;

$factory->define(Currency::class, function (Faker $faker) {
    return [
        'id' => function () use ($faker) {
            $currencies = (new \Money\Currencies\ISOCurrencies())->getIterator();

            return $faker->unique()->randomElement((array)$currencies)->getCode();
        },
        'currency' => $faker->word,
        'numeric_code' => $faker->unique()->numberBetween(100, 999),
        'minor_unit' => rand(0, 2),
        'enabled_at' => $faker->dateTime,
    ];
});
