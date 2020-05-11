<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Vote;
use App\Post;
use App\Community;
use App\Comment;

class VoteController extends Controller
{
  public function postVote(Post $post, Request $request)
  {
    // cannot vote if unauthenticated
    if (!Auth::check()) {
      return response()->json([
        'success' => false,
        'reason' => 'unauthenticated',
        'redirect' => route('front.users.login'),
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
    $votes = $post->votes->where('user', $user);
    
    if ($votes->count() > 1) {
      foreach ($votes as $vote) {
        $vote->delete();
      }
      return response()->json([
        'success' => false,
        'reason' => 'User has too many votes for this posts. All votes deleted',
        'state' => 'none',
      ]);
    } elseif ($votes->count() == 0) {
      $vote = new Vote;
      $vote->up = $request->input('rating') == 'up' ? true : false;
      $vote->user()->associate($user);
      $vote->post()->associate($post);
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
  
  public function commentUp(Request $request, Community $community, Post $post, $slug)
  {
    $vote = new Vote;
    $vote->up = true;
    $vote->user()->associate(Auth::user());
    $vote->comment()->associate(Comment::find($request->input('comment_id')));
    
    $vote->save();
    
    return back()->with('message', 'vote bien pris en compte');
  }
  
  public function commentDown(Request $request, Community $community, Post $post, $slug)
  {
    $vote = new Vote;
    $vote->up = false;
    $vote->user()->associate(Auth::user());
    $vote->comment()->associate(Comment::find($request->input('comment_id')));
    
    $vote->save();
    
    return back()->with('message', 'vote bien pris en compte');
  }
}
