<?php

namespace App\Http\Controllers;

use App\CommunityRule;
use Illuminate\Http\Request;

use App\User;
use App\Community;
use Illuminate\Support\Facades\Validator;

class CommunityRuleController extends Controller
{
  public function index()
  {    
    $communityRules = CommunityRule::paginate(100);
    return view('admin.community-rules.index', compact('communityRules'));
  }

  public function create()
  {
    $users = user::all();
    $communities = Community::all();
    $communityRule = new CommunityRule(); // passes an empty model to the view
    return view('admin.community-rules.create', compact('users', 'communities', 'communityRule'));
  }

  public function store(Request $request)
  {
    $data = [
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'order' => $request->input('order'),
      'creator_id' => $request->input('creator_id'),
      'community_id' => $request->input('community_id'),
    ];
    $rules = [
      'title' => ['required', 'string', 'max:100'],
      'description' => ['nullable', 'string', 'max:1000'],
      'order' => ['required', 'integer', 'min:1', 'max:20'],
      'creator_id' => ['required', 'integer', 'exists:App\User,id'],
      'community_id' => ['required', 'integer', 'exists:App\Community,id'],
    ];
    $validator = Validator::make($data, $rules)->validate();
    
    $communityRule = CommunityRule::create($validator);
      
    return redirect(route('community-rules.show', ['community_rule' => $communityRule]))
    ->with('message', 'Community rule created successfully');
  }

  public function show(CommunityRule $communityRule)
  {
    return view('admin.community-rules.show', compact('communityRule'));
  }

  public function edit(CommunityRule $communityRule)
  {
    $users = user::all();
    $communities = Community::all();
    return view('admin.community-rules.edit', compact('communityRule', 'users', 'communities'));
  }

  public function update(Request $request, CommunityRule $communityRule)
  {
    $data = [
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'order' => $request->input('order'),
      'creator_id' => $request->input('creator_id'),
      'community_id' => $request->input('community_id'),
    ];
    $rules = [
      'title' => ['required', 'string', 'max:100'],
      'description' => ['nullable', 'string', 'max:1000'],
      'order' => ['required', 'integer', 'min:1', 'max:20'],
      'creator_id' => ['required', 'integer', 'exists:App\User,id'],
      'community_id' => ['required', 'integer', 'exists:App\Community,id'],
    ];
    $validator = Validator::make($data, $rules)->validate();
    
    // update model
    $communityRule->update($validator);
    
    // return view
    return redirect(route('community-rules.show', ['community_rule' => $communityRule]))
    ->with('message', 'Community rule updated successfully.');
  }

  public function destroy(CommunityRule $communityRule)
  {
    $communityRule->delete();
    return redirect(route('community-rules.index'))
    ->with('message', 'Community rule deleted successfully.');
  }
}
