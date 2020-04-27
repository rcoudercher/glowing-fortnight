<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
  $title = $faker->text(50);
    return [
      'user_id' => 1,
      'community_id' => 1,
      'notification' => true,
      'public' => true,
      'title' => $title,
      'content' => $faker->text(300),
      'slug' => Str::limit(Str::slug($title, '-'), 50, '_c').'-'.Str::lower(Str::random(7)),
    ];
});
