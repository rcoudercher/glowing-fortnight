<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Auth;
use App\User;
use App\Community;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
  public function account()
  {
    $key = encrypt(Auth::user()->id); // encrypt user id
    return view('settings.account', compact('key'));
  }
  
  public function profile()
  {
    return view('settings.profile');
  }
  
  public function privacy()
  {
    return view('settings.privacy');
  }
  
  public function feed()
  {
    return view('settings.feed');
  }
  
  public function notifications()
  {
    return view('settings.notifications');
  }
  
  public function messaging()
  {
    return view('settings.messaging');
  }
  
  public function showCommunities()
  {
    $user = Auth::user();
    $adminCommunities = $user->adminCommunities;
    $nonAdminCommunities = $user->nonAdminCommunities;
    return view('settings.show-communities', compact('adminCommunities', 'nonAdminCommunities'));
  }
  
  public function editUserPassword()
  {    
    return view('settings.change-password');
  }
  
  public function updateUserPassword(Request $request)
  {    
    // validation
    $validator = request()->validate([
      'user_id' => 'required|integer',
      'old_password' => 'required|string',
      'password' => 'required|string|min:8|confirmed',
    ]);
    
    // retrieve the user requesting to change his password with the hidden user_id input
    $user = User::find($request->input('user_id'));
    
    // check if the given old password matches the records
    if (Hash::check($request->input('old_password'), $user->password)) {
      
      // if old password is correct, then update password
      $user->password = Hash::make($request->input('password'));
      $user->save();
      
      // also send an email to the user
      
      return redirect(route('front.users.settings.index'))->with('message', 'Mot de passe modifié avec succès.');
    }
    
    return redirect(route('front.users.settings.password.edit'))->with('message', 'Echec de la mise à jour. Ancien mot de passe incorrect.');
  }
  
  
}
