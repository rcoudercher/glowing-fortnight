<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {  
    $posts = Post::paginate(20);
    return view('home', compact('posts'));
  }
}
