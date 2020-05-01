<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Community;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Community::class, function (Faker $faker) {
  
  // find unique hash
  $hashes = Community::all()->pluck('hash');
  $hash = Str::random(6);
  while ($hashes->contains($hash)) {
    $hash = Str::random(6);
  }
  // end find unique hash
  
  $name = $faker->firstName.$faker->numberBetween(1000,9000);
  
    return [
      'creator_id' => $faker->randomDigitNot(0),
      'hash' => $hash,
      'name' => Str::lower($name),
      'display_name' => $name,
      'title' => $faker->text(50),
      'description' => $faker->text(300),
      'submission_text' => $faker->text(300),
    ];
});
