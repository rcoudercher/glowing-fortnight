<?php

namespace App\Http\Controllers\Admin;

use App\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Auth;
use App\Http\Controllers\Controller;

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
      'creator_id' => $request->input('creator_id'),
      'type' => $request->input('type'),      
      'name' => Str::lower($request->input('name')),
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'submission_text' => $request->input('submission_text'),
    ];
    
    $rules = [
      'creator_id' => ['required', 'integer'],
      'type' => ['required', 'integer'],
      'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', 'unique:communities'],
      'title' => ['nullable', 'string'],
      'description' => ['nullable', 'string'],
      'submission_text' => ['nullable', 'string'],
    ];
    
    $validator = Validator::make($data, $rules)->validate();
    
    // find unique hash
    $hashes = Community::all()->pluck('hash');
    $hash = Str::random(6);
    while ($hashes->contains($hash)) {
      $hash = Str::random(6);
    }
    // end find unique hash
    
    $validator['hash'] = $hash;
    $validator['display_name'] = $name;
    
    Community::create($validator);

    return redirect(route('admin.communities.index'))->with('message', 'Community created successfully.');
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
      'creator_id' => $request->input('creator_id'),
      'type' => $request->input('type'),      
      'name' => Str::lower($request->input('name')),
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'submission_text' => $request->input('submission_text'),
    ];
    
    $rules = [
      'creator_id' => ['required', 'integer'],
      'type' => ['required', 'integer'],
      'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', Rule::unique('communities')->ignore($community)],
      'title' => ['nullable', 'string'],
      'description' => ['nullable', 'string'],
      'submission_text' => ['nullable', 'string'],
    ];
    
    $validator = Validator::make($data, $rules)->validate();
        
    $validator['display_name'] = $name;
  
    
    // update model
    $community->update($validator);
    
    return redirect(route('admin.communities.show', ['community' => $community]))
    ->with('message', 'Community updated successfully.');
    
  }

  public function destroy(Community $community)
  {
    $community->delete();
    return redirect(route('admin.communities.index'))->with('message', 'Community deleted successfully.');
  }
  
}
