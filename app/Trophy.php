<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trophy extends Model
{
  // allows mass assignment on any field of the model
  protected $guarded = [];
  
  // the users that belong to the badge
  public function users()
  {
      return $this->belongsToMany('App\User');
  }
}
