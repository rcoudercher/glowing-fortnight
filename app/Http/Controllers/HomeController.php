<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

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
