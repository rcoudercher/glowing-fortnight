<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Comment;
use App\Community;
use App\Post;
use App\Vote;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
  public function store(Request $request, Community $community, Post $post, $slug)
  {
    // check if slugs are matching
    if ($post->slug != $slug) {
      abort(404);
    }
    
    $data = [
      'content' => strip_tags($request->input('content'), ['<p>','<a>','<strong>','<em>','<span>','<h2>','<blockquote>','<ul>','<ol>','<li>']),
    ];
    
    $rules = [
      'content' => ['required', 'string', 'max:2000'],
    ];
    
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
        
    // associate a parent comment if a parent_id exists
    if ($request->has('parent_id')) {
      
      // throws an error if the decrypted has is wrong
      try {
        $hash = decrypt($request->input('parent_id'));
      } catch (DecryptException $e) {
        return back()->with('error', 'something went wrong');
      }
      
      // throws an error if no model is found with the given hash
      try {
        $parent = Comment::where('hash', $hash)->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return back()->with('error', 'something went wrong');
      }
      
      // throws an error if the found model doesn't belog to this post
      if (!$post->comments->contains($parent)) {
        return back()->with('error', 'something went wrong');
      }
      
      $comment->parent()->associate($parent);
    }
    
    $comment->save();
    
    return redirect(route('posts.show', ['community' => $community, 'post' => $post, 'slug' => $post->slug]))
    ->with('message', 'Votre commentaire a bien été publié.');
  }
  
  public function vote(Comment $comment, Request $request)
  {
    // cannot vote if unauthenticated
    if (!Auth::check()) {
      return response()->json([
        'success' => false,
        'reason' => 'unauthenticated',
        'redirect' => route('users.login'),
      ]);
    }
    
    // check that the correct "rating" parameters were passed through
    if ($request->input('rating') != 'up' && $request->input('rating') != 'down') {
      return response()->json([
        'success' => false,
        'reason' => 'wrong rating parameters',
      ]);
    }
    
    $user = Auth::user();
    $votes = $comment->votes->where('user', $user);
    
    if ($votes->count() > 1) {
      foreach ($votes as $vote) {
        $vote->delete();
      }
      return response()->json([
        'success' => false,
        'reason' => 'User had too many votes for this comment. All votes deleted',
        'state' => 'none',
      ]);
    } elseif ($votes->count() == 0) {
      $vote = new Vote;
      $vote->up = $request->input('rating') == 'up' ? true : false;
      $vote->user()->associate($user);
      $vote->comment()->associate($comment);
      $vote->save();
      
      $message = $request->input('rating') == 'up' ? 'was no vote, now upvoted' : 'was no vote, now downvoted';
      $state = $request->input('rating') == 'up' ? 'up' : 'down';
      
      return response()->json([
        'success' => true,
        'message' => $message,
        'state' => $state,
      ]);
    } else {
      // $votes->count() == 1
      
      $vote = $votes->first();
      
      if ($vote->up && $request->input('rating') == 'up') {
        $vote->delete();
        $message = 'Was already upvoted. Upvote deleted.';
        $state = 'none';
      } else if ($vote->up && $request->input('rating') == 'down') {
        $vote->up = false;
        $vote->save();
        $message = 'Was Upvoted, now downvoted';
        $state = 'down';
      } else if (!$vote->up && $request->input('rating') == 'up') {
        $vote->up = true;
        $vote->save();
        $message = 'Was downvoted, now upvoted';
        $state = 'up';
      } else if (!$vote->up && $request->input('rating') == 'down') {
        $vote->delete();
        $message = 'Was already downvoted. Downvote deleted.';
        $state = 'none';
      }
      
      return response()->json([
        'success' => true,
        'message' => $message,
        'state' => $state,
      ]);
    }
  }
  
  public function getVoteCount(Comment $comment)
  {
    return response()->json([
      'counter' => $comment->voteCount(),
    ]);
  }
}
