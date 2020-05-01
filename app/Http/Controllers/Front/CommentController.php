<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Comment;
use App\Community;
use App\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
  
  public function store(Request $request, Community $community, Post $post, $slug)
  {
    // check if slugs are matching
    if ($post->slug != $slug) {
      abort(404);
    }
    
    // check if user is loged in
    if (!Auth::check()) {
      return back()->with('error', 'Vous devez être connecté pour écrire un commentaire.');
    }
    
    // data validation first
    $validator = request()->validate([
      'content' => 'required|max:1000',
    ]);
    
    // find unique hash
    $hashes = Comment::all()->pluck('hash');
    $hash = Str::random(7);
    while ($hashes->contains($hash)) {
      $hash = Str::random(7);
    }
    // end find unique hash
    
    $validator['hash'] = $hash;
    
    $comment = Comment::create($validator);
    
    $comment->user()->associate(Auth::user());
    $comment->post()->associate($post);
    $comment->community()->associate($community);
    
    $comment->save();
    
    
    return redirect(route('front.posts.show', ['community' => $community, 'post' => $post, 'slug' => $post->slug]))
    ->with('message', 'Votre message a bien été publié.');
  }
  

}
