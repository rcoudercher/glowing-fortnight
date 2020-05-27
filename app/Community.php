<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Community extends Model
{
  // allows mass assignment on any field of the model
  protected $guarded = [];

  public function creator()
  {
    return $this->belongsTo('App\User');
  }
  
  public function users()
  {
    return $this->belongsToMany('App\User')
    ->withPivot('admin', 'status', 'moderated_at', 'moderated_by')
    ->withTimestamps();
  }
  
  public function pendingUsers()
  {
    return $this->belongsToMany('App\User')->wherePivot('status', 0);
  }
  
  public function approvedUsers()
  {
    return $this->belongsToMany('App\User')->wherePivot('status', 1);
  }
  
  public function rejectedUsers()
  {
    return $this->belongsToMany('App\User')->wherePivot('status', 2);
  }
  
  public function postponedUsers()
  {
    return $this->belongsToMany('App\User')->wherePivot('status', 3);
  }
  
  public function admins()
  {
    return $this->belongsToMany('App\User')->wherePivot('admin', true);
  }
  
  public function nonAdmins()
  {
    return $this->belongsToMany('App\User')->wherePivot('admin', false);
  }
  
  public function isAdmin(User $user)
  {  
    return $this->admins->contains($user);
  }
  
  public function posts()
  {
    return $this->hasMany('App\Post');
  }
  
  public function pendingPosts()
  {
    return $this->posts()->where('status', 0);
  }
  
  public function approvedPosts()
  {
    return $this->posts()->where('status', 1);
  }
  
  public function rejectedPosts()
  {
    return $this->posts()->where('status', 2);
  }
  
  public function postponedPosts()
  {
    return $this->posts()->where('status', 3);
  }
  
  public function comments()
  {
    return $this->hasManyThrough('App\Comment', 'App\Post');
  }
  
  public function pendingComments()
  {
    return $this->comments()->where('comments.status', 0);
  }
  
  public function approvedComments()
  {
    return $this->comments()->where('comments.status', 1);
  }
  
  public function rejectedComments()
  {
    return $this->comments()->where('comments.status', 2);
  }
  
  public function postponedComments()
  {
    return $this->comments()->where('comments.status', 3);
  }
  
  public function communityRules()
  {
    return $this->hasMany('App\CommunityRule');
  }
  
  public function getModerationCount()
  {
    $pendingCommentsCount = $this->pendingComments->count();
    $pendingPostsCount = $this->pendingPosts->count();
    $pendingUsersCount = $this->pendingUsers->count();
    
    return $pendingCommentsCount + $pendingPostsCount + $pendingUsersCount;
  }
}
