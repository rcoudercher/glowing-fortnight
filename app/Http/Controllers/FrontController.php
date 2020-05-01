<?php

namespace App\Http\Controllers;

use App\Community;
use App\Post;
use App\User;
use App\Comment;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FrontController extends Controller
{
  
  public function showUser(User $user)
  {
    return view('users.show', compact('user'));
  }
  

  
}
