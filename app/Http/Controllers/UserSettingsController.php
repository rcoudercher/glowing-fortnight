<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSettingsController extends Controller
{  
  public function account()
  {
    return view('users.settings.account');
  }
  
  public function profile()
  {
    return view('users.settings.profile');
  }
  
  public function privacy()
  {
    return view('users.settings.privacy');
  }
  
  public function feed()
  {
    return view('users.settings.feed');
  }
  
  public function notifications()
  {
    return view('users.settings.notifications');
  }
  
  public function messaging()
  {
    return view('users.settings.messaging');
  }
  
  public function editUserPassword()
  {    
    return view('users.settings.change-password');
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
      
      return redirect(route('user.settings.index'))->with('message', 'Mot de passe modifié avec succès.');
      
    }
    
    return redirect(route('user.settings.password.edit'))->with('message', 'Echec de la mise à jour. Ancien mot de passe incorrect.');

  }
  
  
}
