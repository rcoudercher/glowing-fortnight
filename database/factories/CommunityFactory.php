<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Community;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Community::class, function (Faker $faker) {
    return [
      'name' => Str::slug($faker->name, '-'),
      'title' => $faker->text(50),
      'description' => $faker->text(300),
    ];
});
