<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityRule extends Model
{
  use SoftDeletes;
  
  // allows mass assignment on any field of the model
  protected $guarded = [];
  
  public function community()
  {
    return $this->belongsTo('App\Community');
  }
  
  public function creator()
  {
    return $this->belongsTo('App\User');
  }
}
