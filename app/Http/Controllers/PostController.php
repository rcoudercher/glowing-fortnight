<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index()
    {
      $posts = Post::paginate(100);
      return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
      $post = new Post(); // passes an empty model to the view
      return view('admin.posts.create', compact('post'));
    }

    public function store(Request $request)
    {
      $validator = request()->validate([
        'user_id' => 'required|integer',
        'community_id' => 'required|integer',
        'notification' => 'required|integer',
        'public' => 'required|integer',
        'title' => 'required',
        'content' => 'required',
      ]);
      
      // find unique hash
      $hashes = Post::all()->pluck('hash');
      $hash = Str::random(6);
      while ($hashes->contains($hash)) {
        $hash = Str::random(6);
      }
      // end find unique hash
      
      $validator['hash'] = $hash;      
      $validator['slug'] = Str::limit(Str::slug($request->input('title'), '_'), 50);
      
      $post = Post::create($validator);      

      return redirect(route('posts.index'))->with('message', 'Post created successfully.');
    }

    public function show(Post $post)
    {
      return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
      return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer',
        'community_id' => 'required|integer',
        'notification' => 'required|integer',
        'public' => 'required|integer',
        'title' => 'required',
        'content' => 'required',
      ])->validate();
      
      $validator['slug'] = Str::limit(Str::slug($request->input('title'), '_'), 50);

      // update model
      $post->update($validator);
      
      // return view
      return redirect(route('posts.show', ['post' => $post]))
      ->with('message', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
      $post->delete();
      return redirect(route('posts.index'))->with('message', 'Post deleted successfully.');
    }
}
