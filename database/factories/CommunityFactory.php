<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Community;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Community::class, function (Faker $faker) {
  
  $name = $faker->firstName.$faker->numberBetween(1000,9000);
  
    return [      
      'name' => Str::lower($name),
      'display_name' => $name,
      'title' => $faker->text(50),
      'description' => $faker->text(300),
    ];
});
