<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Post;
use App\Comment;
use App\Community;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{  
  public function showPosts(User $user)
  {
    $posts = $user->posts->sortByDesc('created_at');
    return view('users.show-posts', compact('user', 'posts'));
  }
  
  public function showComments(User $user)
  {
    // $comment = $user->comments->first();
    // $comment = Comment::all()->find(70);
    
    // dd($comment);
    
    // dd($comment->parent()->user->display_name);
    
    
    $comments = $user->comments->sortByDesc('created_at');
    return view('users.show-comments', compact('user', 'comments'));
  }
  
  public function create()
  {
    $user = new User;
    return view('users.create', compact('user'));
  }
  
  public function store(Request $request)
  {    
    $data = [
      'email' => $request->input('email'),
      'name' => Str::lower($request->input('name')),
      'password' => $request->input('password'),
    ];
    
    $rules = [
      'email' => ['required', 'string', 'email', 'max:80', 'unique:users'],
      'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', 'unique:users'],
      'password' => ['required', 'string', 'min:8'],
    ];
    
    $validator = Validator::make($data, $rules)->validate();
    
    $user = User::create([
        'name' => $validator['name'],
        'display_name' => $request->input('name'),
        'email' => $validator['email'],
        'password' => Hash::make($validator['password']),
    ]);
    
    // send email to the new user
    
    // log new user in
    if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
      return redirect(route('home'))->with('message', 'Votre compte a bien été créé. Bienvenue !');
    }
    
    return redirect(route('home'))->with('error', 'Une erreur s\'est produite.');
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
      return redirect(route('home'))->with('error', 'Echec de la suppression du compte. Veuillez essayer de nouveau.');
    }
    
    $user = Auth::user();
    
    // check if logged user id matches the decrypted key
    if ($user->id != $decrypted) {
      Auth::guard('web')->logout();
      return redirect(route('home'))
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
    
    return redirect(route('home'))->with('message', 'Votre compte a bien été supprimé.');
  }
  
  public function approve(Community $community, User $user)
  {
    $community->users()->updateExistingPivot($user, ['status' => 1]);
    return back()->with('message', 'Nouveau membre accepté');
  }
  
  public function reject(Community $community, User $user)
  {
    $community->users()->updateExistingPivot($user, ['status' => 2]);
    return back()->with('message', 'Nouveau membre refusé');
  }
  
  public function postpone(Community $community, User $user)
  {
    $community->users()->updateExistingPivot($user, ['status' => 3]);
    return back()->with('message', 'Nouveau membre reporté');
  }
}
