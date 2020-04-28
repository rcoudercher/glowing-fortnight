<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trophy;
use Faker\Generator as Faker;

$factory->define(Trophy::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
      'image' => 'https://www.redditstatic.com/awards2/2_year_club-40.png',
    ];
});
