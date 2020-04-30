<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Comment::class, function (Faker $faker) {
    return [
      'user_id' => 1,
      'post_id' => 1,
      'community_id' => 1,
      'parent_id' => null,
      'hash' => Str::random(7),
      'content' => $faker->text(300),
    ];
});
