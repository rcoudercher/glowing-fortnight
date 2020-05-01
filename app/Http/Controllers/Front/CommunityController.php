<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Community;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommunityController extends Controller
{
  public function index()
  {
    $communities = Community::all();
    return view('communities.index', compact('communities'));
  }
  
  public function show(Community $community)
  {
    return view('communities.show', compact('community'));
  }
    
  public function join(Community $community)
  {
    if (!Auth::check()) {
      return redirect(route('login'))
      ->with('error', 'Vous devez être connecté pour rejoindre une communauté.');
    }
    
    $user = Auth::user(); // retrieve logged in user
    
    $communities = $user->communities; // retrieve user's communities
    
    // check if the user isn't already a member of the community he's now requesting to join
    if ($communities->contains($community)) {
      return redirect(route('front.communities.show', ['community' => $community]))
      ->with('error', 'Vous êtes déja membre de cette communauté.');
    }
        
    $user->communities()->attach($community); // attach this new community
    
    return back()->with('message', 'Vous faites maintenant partie de r/'.$community->name);
    
  }
  
  public function leave(Community $community)
  {
    if (!Auth::check()) {
      return redirect(route('login'))
      ->with('error', 'Vous devez être connecté pour quitter une communauté.');
    }
    
    $user = Auth::user();
    $user->communities()->detach($community);
    return back()->with('message', 'Vous avez bien quitté r/'.$community->name);
  }
  
}
