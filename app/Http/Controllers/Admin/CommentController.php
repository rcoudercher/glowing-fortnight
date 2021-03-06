<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {
      $comments = Comment::paginate(20);
      return view('admin.comments.index', compact('comments'));
    }

    public function create()
    {
      $comment = new Comment(); // passes an empty model to the view
      return view('admin.comments.create', compact('comment'));
    }

    public function store(Request $request)
    {
      $validator = request()->validate([
        'user_id' => 'required|integer',
        'post_id' => 'required|integer',
        'parent_id' => 'nullable|integer',
        'content' => 'required',
      ]);
      
      // find unique hash
      $hashes = Comment::all()->pluck('hash');
      $hash = Str::random(7);
      while ($hashes->contains($hash)) {
        $hash = Str::random(7);
      }
      // end find unique hash
      
      $validator['hash'] = $hash;
      
      Comment::create($validator);

      return redirect(route('admin.comments.index'))
      ->with('message', 'Comment created successfully.');
    }

    public function show(Comment $comment)
    {
      return view('admin.comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
      return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer',
        'post_id' => 'required|integer',
        'parent_id' => 'nullable|integer',
        'content' => 'required',
      ])->validate();

      // update model
      $comment->update($validator);
      
      // return view
      return redirect(route('admin.comments.show', ['comment' => $comment]))
      ->with('message', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
      $comment->delete();
      return redirect(route('admin.comments.index'))
      ->with('message', 'Comment deleted successfully.');
    }
    
    public function setPending(Comment $comment)
    {
      $comment->status = 0;
      $comment->save();
      return back()->with('message', 'Comment set pending successfully.');
    }
    
    public function approve(Comment $comment)
    {
      $comment->status = 1;
      $comment->save();
      return back()->with('message', 'Comment approved successfully.');
    }
    
    public function reject(Comment $comment)
    {
      $comment->status = 2;
      $comment->save();
      return back()->with('message', 'Comment rejected successfully.');
    }
    
    public function postpone(Comment $comment)
    {
      $comment->status = 3;
      $comment->save();
      return back()->with('message', 'Comment postponed successfully.');
    }
}
