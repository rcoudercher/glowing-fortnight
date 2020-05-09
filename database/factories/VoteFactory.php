<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vote;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    return [
      // 'user_id' => 1,
      // 'post_id' => 1,
      // 'comment_id' => 1,
      'up' => random_int(0,1),
    ];
});
