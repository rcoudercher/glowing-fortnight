<?php

namespace App\Http\Controllers\Front;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
  public function index()
  {  
    $posts = Post::all()->sortByDesc(function($post) {
      return $post->wilsonScore();
    });
    
    return view('home', compact('posts'));
  }
}
