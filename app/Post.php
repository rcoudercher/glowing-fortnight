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
  
  public function voteCount()
  {
    return $this->upVotes()->count() - $this->downVotes()->count();
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
  
  public function rootComments()
  {
    return $this->comments()->whereNull('parent_id');
  }
  
  public function isPending()
  {  
    return $this->status == 0 ? true : false;
  }
  
  public function isApproved()
  {  
    return $this->status == 1 ? true : false;
  }
  
  public function isRejected()
  {  
    return $this->status == 2 ? true : false;
  }
  
  public function isPostponed()
  {  
    return $this->status == 3 ? true : false;
  }
  
  public function scopePending($query)
  {
    return $query->where('status', 0);
  }
  
  public function scopeApproved($query)
  {
    return $query->where('status', 1);
  }
  
  public function scopeRejected($query)
  {
    return $query->where('status', 2);
  }
  
  public function scopePostponed($query)
  {
    return $query->where('status', 3);
  }
  
}
