<?php

namespace App\Http\Controllers\Admin;

use App\Membership;
use App\User;
use App\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
  public function index()
  {
    $memberships = DB::table('community_user')->paginate(80);
    return view('admin.memberships.index', compact('memberships'));
  }

  public function create()
  {  
    $users = User::all();
    $communities = Community::all();
    return view('admin.memberships.create', compact('users', 'communities'));
  }

  public function store(Request $request)
  {  
    $data = $request->validate([
      'user_id' => 'required|integer|exists:App\User,id',
      'community_id' => 'required|integer|exists:App\Community,id',
      'admin' => 'required|boolean',
      'status' => 'required|integer|min:0|max:3',
    ]);
    
    $user = User::find($request->input('user_id'));
    $community = Community::find($request->input('community_id'));
        
    if ($user->communities->contains($community)) {
      return back()->with('message', 'This relationship already exists.');
    }
    
    $user->communities()->attach($community, [
      'admin' => $request->input('admin'),
      'status' => $request->input('status'),
    ]);
      
    return redirect(route('admin.memberships.index'))
    ->with('message', 'Membership created successfully');
  }

  public function show($id)
  {
    $membership = DB::table('community_user')->where('id', $id)->first();
    return view('admin.memberships.show', compact('membership'));
  }

  public function edit($id)
  {
    $membership = DB::table('community_user')->where('id', $id)->first();
    $users = User::all();
    $communities = Community::all();
    return view('admin.memberships.edit', compact('membership', 'users', 'communities'));
  }

  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'admin' => 'required|boolean',
      'status' => 'required|integer|min:0|max:3',
    ]);
        
    $user = User::find($request->input('user_id'));
    $community = Community::find($request->input('community_id'));
    
    $user->communities()->updateExistingPivot($community, $data);
    
    // return view
    return redirect(route('admin.memberships.index'))
    ->with('message', 'Membership updated successfully.');
  }

  public function destroy($id)
  {
    $membership = DB::table('community_user')->where('id', $id)->first();
    $user = User::find($membership->user_id);
    $community = Community::find($membership->community_id);
    
    $user->communities()->detach($community);

    return redirect(route('admin.memberships.index'))
    ->with('message', 'Community successfully detached from user\'s commuities.');
  }
  
  public function setPending($id)
  {
    $affected = DB::table('community_user')->where('id', $id)->update(['status' => 0]);
    
    if ($affected) {
      return back()->with('message', 'Membership set pending successfully.');
    } else {
      return back()->with('message', 'Set membership pending failed.');
    }
  }
  
  public function approve($id)
  {  
    $affected = DB::table('community_user')->where('id', $id)->update(['status' => 1]);
    
    if ($affected) {
      return back()->with('message', 'Membership approved successfully.');
    } else {
      return back()->with('message', 'Failed approving Membership.');
    }
  }
  
  public function reject($id)
  {
    $affected = DB::table('community_user')->where('id', $id)->update(['status' => 2]);
    
    if ($affected) {
      return back()->with('message', 'Membership rejected successfully.');
    } else {
      return back()->with('message', 'Failed rejecting membership.');
    }
  }
  
  public function postpone($id)
  {
    $affected = DB::table('community_user')->where('id', $id)->update(['status' => 3]);
    
    if ($affected) {
      return back()->with('message', 'Membership postponed successfully.');
    } else {
      return back()->with('message', 'Failed postponing membership .');
    }
  }  
}
