<?php

namespace App\Http\Controllers;

use App\Community;
use App\Post;
use App\User;
use Auth;

use Illuminate\Http\Request;

class FrontController extends Controller
{
  public function showCommunity(Community $community)
  {
    // check if there's a member and, if there is, if the member is a member of the community
    $isMember = false;
    if (Auth::check()) {
      $user = Auth::user();
      $isMember = $user->communities->contains($community);
    }
    
    return view('communities.show', compact('community', 'isMember'));
  }
  
  public function showPost(Community $community, Post $post)
  {
    return view('posts.show', compact('community', 'post'));
  }
  
  public function showUser(User $user)
  {
    return view('users.show', compact('user'));
  }
  
  public function createPost(Community $community)
  {
    return view('posts.create', compact('community'));
  }
}
