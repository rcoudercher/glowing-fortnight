<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Post;
use App\Comment;
use App\Membership;
use Illuminate\Support\Facades\DB;

class ModerationController extends Controller
{  
  public function memberships()
  {
    $memberships = DB::table('community_user')->where('status', 0)->get();
    return view('admin.moderation.memberships', compact('memberships'));
  }
  
  public function posts()
  {
    $posts = Post::pending()->get();
    return view('admin.moderation.posts', compact('posts'));
  }
  
  public function comments()
  {
    $comments = Comment::pending()->get();
    return view('admin.moderation.comments', compact('comments'));
  }
  
}
