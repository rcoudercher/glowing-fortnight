<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CommunityRule;
use Faker\Generator as Faker;

$factory->define(CommunityRule::class, function (Faker $faker) {
    return [
      'title' => $faker->text(20),
      'description' => $faker->text(80),
      'order' => random_int(1,10),
    ];
});
