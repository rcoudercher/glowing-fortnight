<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // first wave of coments without parent_id
      factory(App\Comment::class, 20)->create()->each(function($comment) {
        $comment->user()->associate(App\User::all()->random());
        $post = App\Post::all()->random();
        $comment->post()->associate($post);
        $community = $post->community;
        $comment->community()->associate($community);
        $comment->save();
      });
      
      // second wave of coments with parent_id
      factory(App\Comment::class, 10)->create()->each(function($comment) {
        $comment->user()->associate(App\User::all()->random());
        $post = App\Post::all()->random();
        $comment->post()->associate($post);
        $community = $post->community;
        $comment->community()->associate($community);
        $comment->parent_id = Arr::random([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,19,20]);
        $comment->save();
      });
    }
}
