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
    return $this->post->community();
  }
  
  public function parent()
  {
    return $this->belongsTo('App\Comment');
  }
  
  public function getEncryptedHash()
  {
    return encrypt($this->hash);
  }
  
  public function children()
  {
    return Comment::where('parent_id', $this->id)->get();
  }
  
  public function isChild()
  {
    if (is_null($this->parent_id)) {
      return false;
    } else {
      return true;
    }
  }
  
  
}
