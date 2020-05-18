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
    
    // relationships functions
    
    // the badges that belong to the user
    public function trophies()
    {
      return $this->belongsToMany('App\Trophy');
    }
    
    // the subs that this user belongs to
    public function communities()
    {
      return $this->belongsToMany('App\Community')->withPivot('admin')->withTimestamps();
    }
    
    public function adminCommunities()
    {
      return $this->belongsToMany('App\Community')->wherePivot('admin', true);
    }
    
    public function nonAdminCommunities()
    {
      return $this->belongsToMany('App\Community')->wherePivot('admin', false);
    }
    
    public function isAdmin(Community $community)
    {
      return $this->adminCommunities->contains($community);  
    }
    
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
    public function communityRules()
    {
      return $this->hasMany('App\CommunityRule', 'creator_id');
    }
    
    public function sentMessages()
    {
      return $this->hasMany('App\Message', 'from_id');
    }
    
    public function receivedMessages()
    {
      return $this->hasMany('App\Message', 'to_id');
    }
    
    public function messages()
    {
      return $this->sentMessages->merge($this->receivedMessages);
    }
    
    public function unreadMessages()
    {
      return $this->receivedMessages()->whereNull('read_at');
    }
    
    public function archivedMessages()
    {
      return $this->messages()->whereNotNull('archived_at');
    }
}
