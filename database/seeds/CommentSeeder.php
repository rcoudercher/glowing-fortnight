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
      factory(App\Comment::class, 60)->create()->each(function($comment) {
        $comment->user()->associate(App\User::all()->random());
        $post = App\Post::all()->random();
        $comment->post()->associate($post);
        $comment->save();
      });
            
      // second wave of coments with parent_id
      factory(App\Comment::class, 20)->create()->each(function($comment) {
        $comment->user()->associate(App\User::all()->random());
        
        
        // find a post that has root comments
        $post = App\Post::all()->random();
        while ($post->comments->count() == 0) {
          $post = App\Post::all()->random();
        }
        $comment->post()->associate($post);
        
        $comment->parent_id = App\Comment::all()->where('post_id', $post->id)->pluck('id')->random();
        $comment->save();
      });
    }
}
