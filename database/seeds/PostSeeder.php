<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Post::class, 20)->create()->each(function($post) {
        $post->user()->associate(App\User::all()->random());
        $post->community()->associate(App\Community::all()->random());
        $post->save();
      });
    }
}
