<?php

use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
  public function run()
  {
    factory(App\Vote::class, 50)->create()->each(function($vote) {
      $vote->user()->associate(App\User::all()->random());
      if (random_int(0,1)) {
        $vote->post()->associate(App\Post::all()->random());
      } else {
        $vote->comment()->associate(App\Comment::all()->random());
      }
      $vote->save();
    });
  }
}
