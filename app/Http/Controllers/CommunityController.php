<?php

namespace App\Http\Controllers;

use App\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Auth;

class CommunityController extends Controller
{
  public function index()
  {
    $communities = Community::paginate(20);
    return view('admin.communities.index', compact('communities'));
  }

  public function create()
  {
    $community = new Community(); // passes an empty model to the view
    return view('admin.communities.create', compact('community'));
  }

  public function store(Request $request)
  {
    $name = $request->input('name');
    
    $data = [
      'name' => Str::lower($request->input('name')),
      'title' => $request->input('title'),
      'description' => $request->input('description'),
    ];
    
    $rules = [
      'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', 'unique:communities'],
      'title' => ['nullable', 'string'],
      'description' => ['nullable', 'string'],
    ];
    
    $validator = Validator::make($data, $rules)->validate();
        
    $validator['display_name'] = $name;
    
    Community::create($validator);

    return redirect(route('communities.index'))->with('message', 'Community created successfully.');
  }

  public function show(Community $community)
  {
    return view('admin.communities.show', compact('community'));
  }

  public function edit(Community $community)
  {
    return view('admin.communities.edit', compact('community'));
  }

  public function update(Request $request, Community $community)
  {
    
    $name = $request->input('name');
    
    $data = [
      'name' => Str::lower($request->input('name')),
      'title' => $request->input('title'),
      'description' => $request->input('description'),
    ];
    
    $rules = [
      'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', Rule::unique('communities')->ignore($community)],
      'title' => ['nullable', 'string'],
      'description' => ['nullable', 'string'],
    ];
    
    $validator = Validator::make($data, $rules)->validate();
        
    $validator['display_name'] = $name;
  
    
    // update model
    $community->update($validator);
    
    return redirect(route('communities.show', ['community' => $community]))
    ->with('message', 'Community updated successfully.');
    
  }

  public function destroy(Community $community)
  {
    $community->delete();
    return redirect(route('communities.index'))->with('message', 'Community deleted successfully.');
  }
  
  public function join(Community $community)
  {
    // check is someone is logged in
    if (Auth::check()) {
      // retrieve logged in user
      $user = Auth::user();
      // retrieve user's communities
      $communities = $user->communities;
      // check if the user isn't already a member of the community he's now requesting to join
      if (!$communities->contains($community)) {
        // if user not already a member, then attach this new community
        $user->communities()->attach($community);
        // redirect to community front index with succes message
        return redirect(route('front.communities.show', ['community' => $community]))
        ->with('message', 'Vous faites maintenant partie de r/'.$community->name);
      } else {
        return redirect(route('front.communities.show', ['community' => $community]))
        ->with('error', 'Vous êtes déja membre de cette communauté.');
      }  
    }
    
    // ask the user to connect first before joining this community
    return redirect(route('login'))
    ->with('error', 'Vous devez être connecté pour rejoindre une communauté.');
  }
  
  public function leave(Community $community)
  {
    if (Auth::check()) {
      $user = Auth::user();
      $user->communities()->detach($community);
      return redirect(route('front.communities.show', ['community' => $community]))
      ->with('message', 'Vous avez bien quitté r/'.$community->name);
    }
    
    // ask the user to connect first before leaving this community
    return redirect(route('login'))
    ->with('error', 'Vous devez être connecté pour quitter une communauté.');
    
  }  
  
}
