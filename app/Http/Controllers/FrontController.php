<?php

namespace App\Http\Controllers;

use App\Community;
use App\Post;
use App\User;

use Illuminate\Http\Request;

class FrontController extends Controller
{
  public function showCommunity(Community $community)
  {
    return view('communities.show', compact('community'));
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
