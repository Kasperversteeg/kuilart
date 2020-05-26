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
        'type' => $faker->randomElement($arrayName = array('RES', 'GRP')),
        'date' => $faker->dateTimeBetween($startdate = '-1 months', $endDate = '+1 months'),
        'name' => $faker->name,
        'startTime' => $faker->time($format = 'H:i'),
        'size' => $faker->numberBetween($min = '1', $max = '90'),
        'notes' => $faker ->paragraph
    ];



});
