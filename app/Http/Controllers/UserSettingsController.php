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
    
    if (Auth::check()) {
      
      // check if hidden key was modified
      try {
        $decrypted = decrypt($request->input('key'));
      } catch (DecryptException $e) {
        return redirect(route('user.settings.index'))->with('error', 'Echec de la suppression du compte. Veuillez essayer de nouveau.');
      }
      
      $user = Auth::user();
      
      // check if logged user id matches the decrypted key
      if ($user->id == $decrypted) {
        
        // if it all matches, then we can start deleting the user
        
        // 1. remove user memberships
        $user->communities()->sync([]);
        
        // 2. all comments and posts 'deleted' colums are now set to true
        
        foreach ($user->posts as $post) {
          $post->deleted = true;
          $post->save();
        }
                
        foreach ($user->comments as $comment) {
          $comment->deleted = true;
          $comment->save();
        }
        
        
        // 3. send email
        
        
        // delete user
        
        $user->deleted = true;
        
        
        // clean up the user model, i.e. set sensitive values to null. ONLY EMAIL IS KEPT
        $user->name= NULL;
        $user->display_name= NULL;
        $user->password= NULL;
        $user->description= NULL;
        $user->remember_token= NULL;
        
        $user->save();
        
        // log the user out for the last time
        Auth::guard('web')->logout();        
        
        return redirect(route('home'))->with('message', 'Votre compte a bien été supprimé.');
        
        
      }
      
      return redirect(route('user.settings.index'))
      ->with('error', 'Echec de la suppression du compte. Veuillez essayer de nouveau.');
      
      
    }
    
    // ask the user to connect first before joining this community
    return redirect(route('login'))
    ->with('error', 'Vous devez être connecté pour rejoindre une communauté.');
    
  }
  
  
}
