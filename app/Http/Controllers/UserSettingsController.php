<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;

class UserSettingsController extends Controller
{
    
  public function account()
  {
    // encrypt user id
    $key = encrypt(Auth::user()->id);  
    
    // dd($key);  
    // 
    // $decrypted = decrypt($key);
    // 
    // dd($decrypted);
    
    return view('users.settings.account', compact('key'));
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
  
  public function destroyUser(Request $request)
  {
    
    // check if hidden key was modified
    try {
      $decrypted = decrypt($request->input('key'));
    } catch (DecryptException $e) {
      return redirect(route('user.settings.index'))->with('error', 'Echec de la suppression du compte. Veuillez essayer de nouveau.');
    }
    
    
    // check if logged user id matches the decrypted key
    if (Auth::user()->id == $decrypted) {
      
      // if it all matches, then we can start deleting the user
      
      // remove user memberships
      
      
      
      dd('egal');
    } else {
      return redirect(route('user.settings.index'))->with('error', 'Echec de la suppression du compte. Veuillez essayer de nouveau.');
    }

    
    // other things to do before deleting the user
    // - remove all memberships
    // - all comments and posts are now owned by u/[supprime]
    // - send email 
    
    
    
    $user->delete();
    return redirect(route('home'))->with('message', 'User deleted successfully.');

    
  }
  
  
}
