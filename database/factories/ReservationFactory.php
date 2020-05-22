<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'date' => $faker->dateTimeBetween($startdate = 'now', $endDate = '+1 months'),
        'description' => $faker ->paragraph
    ];
});
