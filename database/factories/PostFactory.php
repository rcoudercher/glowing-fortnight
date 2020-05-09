<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

$factory->define(Post::class, function (Faker $faker) {
    
  $title = $faker->text(30);
  $data = [
    'hash' => Str::random(6),
    'slug' => Str::limit(Str::slug($title, '_'), 50),
    'up_votes' => $faker->numberBetween(1,500),
    'down_votes' => $faker->numberBetween(1,500),
    'title' => $title,
  ];
  
  switch (Arr::random([1,2,3])) {
    
    case 1:
      $data['type'] = 1;
      $data['content'] = $faker->text(300);
      break;

    case 2:
      $data['type'] = 2;
      $data['image'] = $faker->imageUrl(640, 480, 'cats');
      break;

    case 3:
      $data['type'] = 3;
      $data['link'] = $faker->url;
      break;
  }
  
  return $data;
});
