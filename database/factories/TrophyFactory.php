<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trophy;
use Faker\Generator as Faker;

$factory->define(Trophy::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
    ];
});
