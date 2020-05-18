<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
  
  $user1 = App\User::all()->random();  
  $user2 = App\User::all()->except($user1->id)->random();
  
    return [
      'hash' => Str::random(12),
      'from_id' => $user1->id,
      'to_id' => $user2->id,
      'title' => $faker->text(50),
      'content' => $faker->text(300),
    ];
});
