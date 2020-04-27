<?php

namespace App\Http\Controllers;

use App\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    $validator = request()->validate([
      'name' => 'required|max:70|unique:communities',
      'title' => 'nullable',
      'description' => 'nullable',
    ]);

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
    $validator = Validator::make($request->all(), [
        'name' => ['required', Rule::unique('communities')->ignore($community)],
        'title' => 'nullable',
        'description' => 'nullable',
    ])->validate();
    
    // update model
    $community->update($validator);
    
    return redirect(route('communities.show', ['community' => $community]))->with('message', 'Community updated successfully.');
  }

  public function destroy(Community $community)
  {
    $community->delete();
    return redirect(route('communities.index'))->with('message', 'Community deleted successfully.');
  }
}
