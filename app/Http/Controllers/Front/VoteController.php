<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Vote;
use App\Post;
use App\Community;
use App\Comment;

class VoteController extends Controller
{
  public function postUp(Community $community, Post $post, $slug)
  {
    $vote = new Vote;
    $vote->up = true;
    $vote->user()->associate(Auth::user());
    $vote->post()->associate($post);
    
    $vote->save();
    
    return back()->with('message', 'vote bien pris en compte');
  }
  
  public function postDown(Community $community, Post $post, $slug)
  {
    $vote = new Vote;
    $vote->up = false;
    $vote->user()->associate(Auth::user());
    $vote->post()->associate($post);
    
    $vote->save();
    
    return back()->with('message', 'vote bien pris en compte');
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
