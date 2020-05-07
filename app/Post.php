<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  // allows mass assignment on any field of the model
  protected $guarded = [];
  
  public function user()
  {
    return $this->belongsTo('App\User')->withDefault();
  }
  
  public function community()
  {
    return $this->belongsTo('App\Community')->withDefault();
  }
  
  public function comments()
  {
    return $this->hasMany('App\Comment');
  }
  
  public function rootComments()
  {
    return $this->comments()->whereNull('parent_id');
  }
}
