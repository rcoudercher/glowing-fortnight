<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use Auth;
use App\Post;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
  public function test()
  {
    return view('pages.test');
  }
  
  public function test2()
  {
    $post = Post::find(3);
    
    $votes = $post->votes->where('user', Auth::user());
    $vote = $votes->first();
    
    // dd($vote->up);
    
    return view('pages.test2', compact('post'));
  }
}
