<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
  use SoftDeletes;
  
  // allows mass assignment on any field of the model
  protected $guarded = [];
  
  public function user()
  {
    return $this->belongsTo('App\User');
  }
  
  public function post()
  {
    return $this->belongsTo('App\Post');
  }
  
  public function comment()
  {
    return $this->belongsTo('App\Comment');
  }
  
}
