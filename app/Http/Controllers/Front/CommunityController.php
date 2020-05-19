<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Community;
use App\CommunityRule;
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
    $posts = $community->posts->sortByDesc(function($post) {
      return $post->wilsonScore();
    });
    return view('communities.show', compact('community', 'posts'));
  }
    
  public function join(Community $community)
  {
    $user = Auth::user();
    $communities = $user->communities; // retrieve user's communities
    // check if the user isn't already a member of the community he's requesting to join
    if ($communities->contains($community)) {
      return redirect(route('communities.show', ['community' => $community]))
      ->with('error', 'Vous êtes déja membre de cette communauté.');
    }
    $user->communities()->attach($community); // attach this new community
    return back()->with('message', 'Vous faites maintenant partie de r/'.$community->name);
  }
  
  public function leave(Community $community)
  {  
    $user = Auth::user();
    $user->communities()->detach($community);
    return back()->with('message', 'Vous avez bien quitté r/'.$community->name);
  }
  
  public function showAdminDashboard(Community $community)
  {
    if (!Auth::user()->isAdmin($community)) {
      return redirect(route('communities.show', ['community' => $community]))
      ->with('error', 'Cette page est réservée aux administrateurs de la communauté.');
    }
    
    $lastComment = $community->comments->sortBy('created_at')->last();
    return view('communities.admin', compact('community', 'lastComment'));  
  }
  
  public function create()
  {
    $community = new Community(); // passes an empty model to the view
    return view('communities.create', compact('community'));
  }
  
  public function store(Request $request)
  {  
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
    
    // the user who created the community becomes its first member and admin
    $community->creator()->associate($user);
    $community->save();
    $community->users()->attach($user, ['admin' => true]);
    
    return redirect(route('communities.show', ['community' => $community]))
    ->with('message', 'Votre communauté a bien été créée. A vous de jouer !');
  }
  
  public function edit(Community $community)
  {
    return view('communities.edit', compact('community'));
  }
  
  public function update(Request $request, Community $community)
  {    
    $data = [
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'submission_text' => $request->input('submission_text'),
    ];
    $rules = [
      'title' => ['nullable', 'string'],
      'description' => ['nullable', 'string'],
      'submission_text' => ['nullable', 'string'],
    ];
    $validator = Validator::make($data, $rules)->validate();
    
    $community->update($validator); // update model
    
    return redirect(route('communities.admin.dashboard', ['community' => $community]))
    ->with('message', 'Modifications enregistrées.');
  }
  
  public function editSettings(Community $community)
  {
    if (!Auth::user()->isAdmin($community)) {
      return redirect(route('communities.show', ['community' => $community]))
      ->with('error', 'Cette page est réservée aux administrateurs de la communauté.');
    }
    
    return view('communities.settings', compact('community'));  
  }
  
  public function updateSettings(Request $request, Community $community)
  {
    if (!Auth::user()->isAdmin($community)) {
      return redirect(route('communities.show', ['community' => $community]))
      ->with('error', 'Cette action est réservée aux administrateurs de la communauté.');
    }
    
    // input validation
    $data = [
      'type' => $request->input('type'),
      'mod_members' => $request->input('mod_members'),
      'mod_posts' => $request->input('mod_posts'),
      'mod_comments' => $request->input('mod_comments'),
    ];
    $rules = [
      'type' => ['required', 'integer', 'min:1', 'max:3'],
      'mod_members' => ['required', 'boolean'],
      'mod_posts' => ['required', 'boolean'],
      'mod_comments' => ['required', 'boolean'],
    ];
    $validator = Validator::make($data, $rules)->validate();
    
    $community->update($validator); // update model
    
    return redirect(route('communities.admin.dashboard', ['community' => $community]))
    ->with('message', 'Configuration modifiée');
  }
}
