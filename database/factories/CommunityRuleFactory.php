<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CommunityRule;
use Faker\Generator as Faker;

use Illuminate\Support\Str;

$factory->define(CommunityRule::class, function (Faker $faker) {
    return [
      'hash' => Str::random(6),
      'title' => $faker->text(20),
      'description' => $faker->text(80),
      'order' => random_int(1,10),
    ];
});
