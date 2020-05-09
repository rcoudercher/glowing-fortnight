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
  
  public function votes()
  {
    return $this->hasMany('App\Vote');
  }
  
  public function upVotes()
  {
    return $this->votes->where('up', true);
  }
  
  public function downVotes()
  {
    return $this->votes->where('up', false);
  }
  
  public function wilsonScore()
  {
    // $pos = positive votes
    // $n = total votes
    // $phat ou p̂ is the observed fraction of positive votes
    // $z = confidence
    // see https://www.evanmiller.org/how-not-to-sort-by-average-rating.html
    
    $pos = $this->upVotes()->count();
    $n = $this->votes()->count();
    
    if ($n == 0) {
      return 0;
    }
    
    $z = 1.959964; // 1.959964 = 95.0% confidence, 2.241403 = 97.5% confidence
    $phat = $pos/$n;
    
    return ($phat + $z*$z/(2*$n) - $z * sqrt(($phat*(1-$phat) + $z*$z/(4*$n))/$n))/(1 + $z*$z/$n);
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
