<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Comment;
use App\Community;
use App\Post;
use App\Vote;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
  
  // 3 types of comment :
  // - comment a post (both ancestor_id and parent_id null)
  // - reply to a comment (ancestor_id and parent_id not null and identical)
  // - reply to a reply (ancestor_id and parent_id different)
  
  public function store(Request $request, Post $post)
  {  
    $data = ['content' => $request->input('content')];
    $rules = ['content' => ['required', 'string', 'max:2000']];
    $messages = [
      'content.required' => 'Ce champ est obligatoire',
      'content.string' => 'Le commentaire doit être une chaîne de caractères',
      'content.max' => 'Le commentaire ne doit pas faire plus de :max caractères',
    ];
    $validator = Validator::make($data, $rules, $messages)->validate();
    
    $validator['hash'] = $this->uniqueHash();
    
    // set post status depending on the post moderation policy of the community
    $post->community->mod_comments ? $validator['status'] = 0 : $validator['status'] = 1;
    
    $comment = Comment::create($validator);
    
    $comment->user()->associate(Auth::user());
    $comment->post()->associate($post);
    $comment->save();
    
    return redirect(route('posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]))
    ->with('message', 'Commentaire publié.');
  }
  
  public function reply(Request $request, Comment $comment)
  {
    $data = ['content' => $request->input('content')];
    $rules = ['content' => ['required', 'string', 'max:2000']];
    $messages = [
      'content.required' => 'Ce champ est obligatoire',
      'content.string' => 'Le commentaire doit être une chaîne de caractères',
      'content.max' => 'Le commentaire ne doit pas faire plus de :max caractères',
    ];
  
    $validator = Validator::make($data, $rules, $messages)->validate();
    $validator['hash'] = $this->uniqueHash();;
  
    $reply = Comment::create($validator);
  
    $reply->user()->associate(Auth::user());
    $reply->post()->associate($comment->post);
    $reply->parent_id = $comment->id;
    
    if ($comment->isChild()) {
      // if the comment the user is replying too was not a root comment, the new comment will share the same ancestor_id
      $reply->ancestor_id = $comment->ancestor_id;
    } else {
      // else, i.e. the user was replying toa root comment, the new comment will have this comment if for ancestor
      $reply->ancestor_id = $comment->id;
    }
  
    $reply->save();
  
    return redirect(route('posts.show', ['community' => $comment->community, 'post' => $comment->post, 'slug' => $comment->post->slug]))
    ->with('message', 'Commentaire publié');
  }
  
  public function vote(Comment $comment, Request $request)
  {
    // cannot vote if unauthenticated
    if (!Auth::check()) {
      return response()->json([
        'success' => false,
        'reason' => 'unauthenticated',
        'redirect' => route('users.login'),
      ]);
    }
    
    // check that the correct "rating" parameters were passed through
    if ($request->input('rating') != 'up' && $request->input('rating') != 'down') {
      return response()->json([
        'success' => false,
        'reason' => 'wrong rating parameters',
      ]);
    }
    
    $user = Auth::user();
    $votes = $comment->votes->where('user', $user);
    
    if ($votes->count() > 1) {
      foreach ($votes as $vote) {
        $vote->delete();
      }
      return response()->json([
        'success' => false,
        'reason' => 'User had too many votes for this comment. All votes deleted',
        'state' => 'none',
      ]);
    } elseif ($votes->count() == 0) {
      $vote = new Vote;
      $vote->up = $request->input('rating') == 'up' ? true : false;
      $vote->user()->associate($user);
      $vote->comment()->associate($comment);
      $vote->save();
      
      $message = $request->input('rating') == 'up' ? 'was no vote, now upvoted' : 'was no vote, now downvoted';
      $state = $request->input('rating') == 'up' ? 'up' : 'down';
      
      return response()->json([
        'success' => true,
        'message' => $message,
        'state' => $state,
      ]);
    } else {
      // $votes->count() == 1
      
      $vote = $votes->first();
      
      if ($vote->up && $request->input('rating') == 'up') {
        $vote->delete();
        $message = 'Was already upvoted. Upvote deleted.';
        $state = 'none';
      } else if ($vote->up && $request->input('rating') == 'down') {
        $vote->up = false;
        $vote->save();
        $message = 'Was Upvoted, now downvoted';
        $state = 'down';
      } else if (!$vote->up && $request->input('rating') == 'up') {
        $vote->up = true;
        $vote->save();
        $message = 'Was downvoted, now upvoted';
        $state = 'up';
      } else if (!$vote->up && $request->input('rating') == 'down') {
        $vote->delete();
        $message = 'Was already downvoted. Downvote deleted.';
        $state = 'none';
      }
      
      return response()->json([
        'success' => true,
        'message' => $message,
        'state' => $state,
      ]);
    }
  }
  
  // find unique hash for a new comment
  private function uniqueHash() {
    $hashes = Comment::all()->pluck('hash');
    $hash = Str::random(7);
    while ($hashes->contains($hash)) {
      $hash = Str::random(7);
    }
    return $hash;
  }
  
  public function getVoteCount(Comment $comment)
  {
    return response()->json([
      'counter' => $comment->voteCount(),
    ]);
  }
  
  public function approve(Comment $comment)
  {
    $comment->status = 1;
    $comment->save();
    return back()->with('message', 'Commentaire approuvé');
  }
  
  public function reject(Comment $comment)
  {
    $comment->status = 2;
    $comment->save();
    return back()->with('message', 'Commentaire refusé');
  }
  
  public function postpone(Comment $comment)
  {
    $comment->status = 3;
    $comment->save();
    return back()->with('message', 'Commentaire reporté');
  }
}
