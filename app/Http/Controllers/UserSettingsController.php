<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSettingsController extends Controller
{  
  public function account()
  {
    return view('users.settings.account');
  }
  
  public function profile()
  {
    return view('users.settings.profile');
  }
  
  public function privacy()
  {
    return view('users.settings.privacy');
  }
  
  public function feed()
  {
    return view('users.settings.feed');
  }
  
  public function notifications()
  {
    return view('users.settings.notifications');
  }
  
  public function messaging()
  {
    return view('users.settings.messaging');
  }  
}
