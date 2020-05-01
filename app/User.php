<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Community;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 'display_name', 'email', 'password', 'description', 'deleted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    // other functions
    
    public function isModerator(Community $community)
    {
      return $this->moderatorCommunities->contains($community);  
    }
    
    
    
    
    // relationships functions
    
    // the badges that belong to the user
    public function trophies()
    {
      return $this->belongsToMany('App\Trophy');
    }
    
    // the subs that this user belongs to
    public function communities()
    {
      return $this->belongsToMany('App\Community');
    }
    
    public function moderatorCommunities()
    {
      return $this->belongsToMany('App\Community')->wherePivot('moderator', 1);
    }
    
    public function nonModeratorCommunities()
    {
      return $this->belongsToMany('App\Community')->wherePivot('moderator', 0);
    }
    
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
}
