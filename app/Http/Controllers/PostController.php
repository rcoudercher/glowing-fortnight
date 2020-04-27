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
      $posts = Post::paginate(20);
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
      
      $post = Post::create([
          'user_id' => $validator['user_id'],
          'community_id' => $validator['community_id'],
          'notification' => $validator['notification'],
          'public' => $validator['public'],
          'title' => $validator['title'],
          'content' => $validator['content'],
          'slug' => Str::limit(Str::slug($validator['title'], '-'), 50, '_c').'-'.Str::lower(Str::random(7)),
      ]);      

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
      
      $validator['slug'] = Str::limit(Str::slug($validator['title'], '-'), 50, '_c').'-'.Str::lower(Str::random(7));

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
