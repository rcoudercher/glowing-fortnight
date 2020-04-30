<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
  
  $title = $faker->text(30);
  
  return [
    'hash' => Str::random(6),
    'slug' => Str::limit(Str::slug($title, '_'), 50),
    'title' => $title,
    'content' => $faker->text(300),
  ];
});
