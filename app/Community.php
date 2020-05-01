<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    return $this->belongsToMany('App\User');
  }
  
  public function posts()
  {
    return $this->hasMany('App\Post');
  }
}
