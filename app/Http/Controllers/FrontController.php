<?php

namespace App\Http\Controllers;

use App\Community;
use App\Post;
use App\User;
use App\Comment;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
  
  public function showPost(Community $community, Post $post, $slug)
  {
    // check if the slug in the URL matches the one in record
    if ($post->slug == $slug) {
      return view('posts.show', compact('community', 'post', 'slug'));
    }
    
    // if slugs aren't matching, then throw a 404
    abort(404);
    
  }
  
  public function showUser(User $user)
  {
    return view('users.show', compact('user'));
  }
  
  public function createPost(Community $community)
  {
    $post = new Post(); // passes an empty model to the view
    return view('posts.create', compact('community', 'post'));
  }
  
  public function storePost(Request $request, Community $community)
  {
    if (Auth::check()) {
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
    
    return redirect(route('home'))->with('error', 'Vous devez être connecté pour publier un message.');

  }
  
  public function storeComment(Request $request, Community $community, Post $post, $slug)
  {
    // check if slugs are matching
    if ($post->slug != $slug) {
      abort(404);
    }
    
    // check if user is loged in
    if (!Auth::check()) {
      return route('home')->with('error', 'Vous devez être connecté pour écrire un commentaire.');
    }
    
    // if evrything all right, then create the comment
    
    // data validation first
    $validator = request()->validate([
      'content' => 'required|max:1000',
    ]);
    
    // find unique hash
    $hashes = Comment::all()->pluck('hash');
    $hash = Str::random(7);
    while ($hashes->contains($hash)) {
      $hash = Str::random(7);
    }
    // end find unique hash
    
    $validator['hash'] = $hash;
    
    $comment = Comment::create($validator);
    
    $comment->user()->associate(Auth::user());
    $comment->post()->associate($post);
    $comment->community()->associate($community);
    
    $comment->save();
    
    
    return redirect(route('front.posts.show', ['community' => $community, 'post' => $post, 'slug' => $post->slug]))
    ->with('message', 'Votre message a bien été publié.');
    
    
    
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
}
