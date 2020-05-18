<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
  use SoftDeletes;
  
  // allows mass assignment on any field of the model
  protected $guarded = [];
  
  public function sender()
  {
    return $this->belongsTo('App\User', 'from_id');
  }
  
  public function receiver()
  {
    return $this->belongsTo('App\User', 'to_id');
  }
  
  public function siblings()
  {
    return Message::all()->where('ancestor_id', $this->ancestor_id);
  }
  
  public function isRead()
  {
    return !is_null($this->read_at);
  }
  
  public function isUnread()
  {  
    return is_null($this->read_at);
  }
  
  public function isChild()
  {
    return !is_null($this->ancestor_id);
  }
  
  public function children()
  {
    $children = $this->siblings()->where('created_at', '>', $this->created_at);
    return $children->count() != 0 ? $children->sortBy('created_at') : null;
  }
  
  public function isAncestor()
  {
    return is_null($this->ancestor_id);
  }
  
  public function ancestor()
  {
    return Message::find($this->ancestor_id);
  }
  
  public function ancestors()
  {
    $ancestors = $this->siblings()->where('created_at', '<', $this->created_at)->push($this->ancestor());
    return $ancestors->count() != 0 ? $ancestors->sortBy('created_at') : null;
  }
}
