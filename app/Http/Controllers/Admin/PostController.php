<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\User;
use App\Community;

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
      $users = User::all();
      $communities = Community::all();
      return view('admin.posts.create', compact('post', 'users', 'communities'));
    }

    public function store(Request $request)
    {
      $validator = request()->validate([
        'user_id' => 'required|integer',
        'community_id' => 'required|integer',
        'status' => 'required|integer',
        'title' => 'required|string',
        'content' => 'required|string',
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

      return redirect(route('admin.posts.index'))->with('message', 'Post created successfully.');
    }

    public function show(Post $post)
    {
      return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
      $users = User::all();
      $communities = Community::all();
      return view('admin.posts.edit', compact('post', 'users', 'communities'));
    }

    public function update(Request $request, Post $post)
    {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer',
        'community_id' => 'required|integer',
        'status' => 'required|integer',
        'title' => 'required|string',
        'content' => 'required|string',
      ])->validate();
      
      $validator['slug'] = Str::limit(Str::slug($request->input('title'), '_'), 50);

      // update model
      $post->update($validator);
      
      // return view
      return redirect(route('admin.posts.show', ['post' => $post]))
      ->with('message', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
      $post->delete();
      return redirect(route('admin.posts.index'))
      ->with('message', 'Post deleted successfully.');
    }
    
    public function setPending(Post $post)
    {
      $post->status = 0;
      $post->save();
      return back()->with('message', 'Post set pending successfully.');
    }
    
    public function approve(Post $post)
    {
      $post->status = 1;
      $post->save();
      return back()->with('message', 'Post approved successfully.');
    }
    
    public function reject(Post $post)
    {
      $post->status = 2;
      $post->save();
      return back()->with('message', 'Post rejected successfully.');
    }
    
    public function postpone(Post $post)
    {
      $post->status = 3;
      $post->save();
      return back()->with('message', 'Post postponed successfully.');
    }
    
}
