<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\User;

class UserController extends Controller
{
  public function show(User $user)
  {
    return view('users.show', compact('user'));
  }
  
  
  public function destroy(Request $request)
  {
    
    // check if someone's logged in
    if (!Auth::check()) {
      return redirect(route('login'))->with('error', 'Vous devez être connecté pour rejoindre une communauté.');
    }
    
    // check if hidden key was modified
    try {
      $decrypted = decrypt($request->input('key'));
    } catch (DecryptException $e) {
      Auth::guard('web')->logout();
      return redirect(route('front.home'))->with('error', 'Echec de la suppression du compte. Veuillez essayer de nouveau.');
    }
    
    $user = Auth::user();
    
    // check if logged user id matches the decrypted key
    if ($user->id != $decrypted) {
      Auth::guard('web')->logout();
      return redirect(route('front.home'))
      ->with('error', 'Echec de la suppression du compte. Veuillez essayer de nouveau.');
    }
    
    // if it all matches, we can start deleting the user
    
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
    
    return redirect(route('front.home'))->with('message', 'Votre compte a bien été supprimé.');
  }
}
