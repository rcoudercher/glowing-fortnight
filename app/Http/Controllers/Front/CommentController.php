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
    
    $data = ['content' => strip_tags($request->input('content'), ['<p>','<a>','<strong>','<em>','<span>','<h2>','<blockquote>','<ul>','<ol>','<li>'])];
    $rules = ['content' => ['required', 'string', 'max:2000']];
    $messages = [
      'content.required' => 'Ce champ est obligatoire',
      'content.string' => 'Le commentaire doit être une chaîne de caractères',
      'content.max' => 'Le commentaire ne doit pas faire plus de :max caractères',
    ];
    $validator = Validator::make($data, $rules, $messages)->validate();
    
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
    ->with('message', 'Votre commentaire a bien été publié.');
  }
  

}
