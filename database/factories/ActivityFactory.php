<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'startTime' => $faker->time($format = 'H:i'),
        'endTime' => $faker->time($format = 'H:i'),
        'description' => $faker->sentence($nbWords = 6), 
        'reservation_id' => $faker->numberBetween($min = 0, $max = 50)
    ];
});
