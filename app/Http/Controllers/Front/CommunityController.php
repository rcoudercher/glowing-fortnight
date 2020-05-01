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
  
  public function admin(Community $community)
  {
    return view('communities.admin', compact('community'));  
  }
  
  public function create()
  {
    $community = new Community(); // passes an empty model to the view
    return view('users.settings.communities.create', compact('community'));
  }
  
  public function store(Request $request)
  {
    if (!Auth::check()) {
      return redirect(route('home'))
      ->with('error', 'Vous devez être connecté pour créer une nouvelle communauté.');
    }
    
    $user = Auth::user();
    $name = $request->input('name');
    
    $data = [
      'name' => Str::lower($request->input('name')),
      'description' => $request->input('description'),
    ];
    
    $rules = [
      'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', 'unique:communities'],
      'description' => ['nullable', 'string'],
    ];
    
    $validator = Validator::make($data, $rules)->validate();
    
    // find unique hash
    $hashes = Community::all()->pluck('hash');
    $hash = Str::random(6);
    while ($hashes->contains($hash)) {
      $hash = Str::random(6);
    }
    // end find unique hash
        
    $validator['type'] = 1;
    $validator['hash'] = $hash;
    $validator['display_name'] = $name;
    
    
    $community = Community::create($validator);
    
    
    // the user who created the community becomes its first member and moderator
    $community->creator()->associate($user);
    $community->save();
    $community->users()->attach($user, ['moderator' => true]);
    
    

    return redirect(route('front.communities.show', ['community' => $community]))
    ->with('message', 'Votre communauté a bien été créée. A vous de jouer !');
    
    
    
    
    
    // ---------
    // 
    // if (Auth::check()) {
    //   $name = $request->input('name');
    // 
    //   $data = [
    //     'name' => Str::lower($request->input('name')),
    //     'description' => $request->input('description'),
    //   ];
    // 
    //   $rules = [
    //     'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', 'unique:communities'],
    //     'description' => ['nullable', 'string'],
    //   ];
    // 
    //   $validator = Validator::make($data, $rules)->validate();
    // 
    //   $validator['display_name'] = $name;
    // 
    //   $community = Community::create($validator);
    // 
    // 
    //   // the user who created the community becomes its first member and moderator
    //   $community->users()->attach(Auth::user(), ['moderator' => true]);
    // 
    // 
    // 
    //   return redirect(route('front.communities.show', ['community' => $community]))
    //   ->with('message', 'Votre communauté a bien été créée. A vous de jouer !');
    // }
    // 
    // return redirect(route('home'))
    // ->with('error', 'Vous devez être connecté pour créer une nouvelle communauté.');
    
    
  }
  
}
