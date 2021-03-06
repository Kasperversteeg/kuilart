<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bowling;
use Faker\Generator as Faker;

$factory->define(Bowling::class, function (Faker $faker) {
    return [
        'date' => $faker->date,
        'name' => $faker->name,
        'startTime' => $faker->time($format = 'H:i'),
        'endTime' => $faker->time($format = 'H:i'),
        'lane' => $faker->numberBetween($min = 1, $max = 4)
    ];
});
