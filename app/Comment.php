<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  // allows mass assignment on any field of the model
  protected $guarded = [];
  
  public function user()
  {
    return $this->belongsTo('App\User')->withDefault();
  }
  
  public function post()
  {
    return $this->belongsTo('App\Post')->withDefault();
  }
  
  public function community()
  {
    return $this->belongsTo('App\Community')->withDefault();
  }
}