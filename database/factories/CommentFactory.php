<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Comment::class, function (Faker $faker) {
    return [
      'hash' => Str::random(7),
      'up_votes' => $faker->numberBetween(1,500),
      'down_votes' => $faker->numberBetween(1,500),
      'content' => $faker->text(300),
      'status' => random_int(0,3),
    ];
});
