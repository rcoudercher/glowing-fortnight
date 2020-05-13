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
    return $this->belongsToMany('App\User')->withPivot('admin')->withTimestamps();
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
  
  public function comments()
  {
    return $this->hasManyThrough('App\Comment', 'App\Post');
  }
  
  public function rules()
  {
    return $this->hasMany('App\CommunityRule');
  }
}
