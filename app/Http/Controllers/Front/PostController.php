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
    // dd($request->input('content'));
    
    $type = $request->input('type');
    
    // check if type is correct
    if (!in_array($type, [1,2,3])) {
      return back()->with('error', 'Une erreur s\'est produite.');
    }
    
    $data = ['title' => $request->input('title')];
    $rules = ['title' => ['required', 'string', 'min:4', 'max:100']];
    $messages = [
      'title.required' => 'Vous devez donner un titre à votre publication',
      'title.min' => 'Le titre doit contenir au moins :min caractères',
      'required' => 'Le champ :attribute est obligatoire',
      'min' => 'Le champ :attribute doit faire au moins :min caractères',
    ];
    
    // make a custom data and rules set depending on post type
    switch ($type) {
      case 1:        
        $content = strip_tags($request->input('content'), ['<p>','<a>','<strong>','<em>','<span>','<h2>','<blockquote>','<ul>','<ol>','<li>']);
        $data['content'] = $content;
        $rules['content'] = ['required', 'string', 'max:5000'];
        break;
        
      case 2:
        $data['image'] = $request->file('image');
        $rules['image'] = ['file', 'image', 'max:5000'];
        break;
      
      case 3:
        $data['link'] = $request->input('link');
        $rules['link'] = ['required', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'];
        break;
    }
    
    $validator = Validator::make($data, $rules, $messages)->validate();
    
    // once form data is validated, lets find a unique hash forthis post
    $hashes = Post::all()->pluck('hash');
    $hash = Str::random(6);
    while ($hashes->contains($hash)) {
      $hash = Str::random(6);
    }
    // end find unique hash
    
    $validator['hash'] = $hash;
    $validator['type'] = $type;
    $validator['slug'] = Str::limit(Str::slug($request->input('title'), '_'), 50);
    
    $post = Post::create($validator);
        
    // if image post, upload picture after validation
    if ($type == 2) {
      $post->update(['image' => $request->file('image')->store('uploads', 'public')]);
    }
    
    $post->user()->associate(Auth::user());
    $post->community()->associate($community);
    $post->save();
      
    return redirect(route('front.communities.show', ['community' => $community]))
    ->with('message', 'Votre message a bien été publié.');
  }
}
