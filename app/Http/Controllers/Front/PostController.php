<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Post;
use App\Community;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
  
  public function show(Community $community, Post $post, $slug)
  {
    if ($post->slug != $slug) {
      abort(404); // if slugs aren't matching, then throw a 404
    }
    
    return view('posts.show', compact('community', 'post', 'slug'));
  }
  
  public function create(Community $community)
  {
    $post = new Post(); // passes an empty model to the view
    return view('posts.create', compact('community', 'post'));
  }
  
  
  public function store(Request $request, Community $community)
  {
    if (!Auth::check()) {
      return back()->with('error', 'Vous devez être connecté pour publier un message.');
    }
    
    // first validate the form data
    $data = [
      'title' => $request->input('title'),
      'content' => $request->input('content'),
    ];
    
    $rules = [
      'title' => ['required', 'string'],
      'content' => ['required', 'string'],
    ];
    
    $validator = Validator::make($data, $rules)->validate();
    
    // once form data is validated, lets find a unique hash forthis post
    $hashes = Post::all()->pluck('hash');
    $hash = Str::random(6);
    while ($hashes->contains($hash)) {
      $hash = Str::random(6);
    }
    // end find unique hash
    
    $validator['hash'] = $hash;      
    $validator['slug'] = Str::limit(Str::slug($request->input('title'), '_'), 50);
    
    
    $post = Post::create($validator);
    
    
    $post->user()->associate(Auth::user());
    $post->community()->associate($community);
    $post->save();
      
    return redirect(route('front.communities.show', ['community' => $community]))
    ->with('message', 'Votre message a bien été publié.');
  }
}
