<?php

namespace App\Http\Controllers;

use App\User;
use App\Trophy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function index()
    {
      $users = User::paginate(20);
      return view('admin.users.index', compact('users'));
    }

    public function create()
    {
      return view('admin.users.create', [
        'user' => new User(), // passes an empty model to the view
        'trophies' => Trophy::all(),
      ]);
    }

    public function store(Request $request)
    {
      $name = $request->input('name');
      
      $data = [
        'name' => Str::lower($request->input('name')),
        'email' => Str::lower($request->input('email')),
        'password' => $request->input('password'),
        'password_confirmation' => $request->input('password_confirmation'),
        'description' => $request->input('description'),
      ];
      
      $rules = [
        'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'description' => ['nullable', 'string'],
      ];
      
      $validator = Validator::make($data, $rules)->validate();
      
      $validator['password'] = Hash::make($validator['password']); // hashes password
      $validator['display_name'] = $name;
      $user = User::create($validator);
            
      // saves related models in pivot tables
      $user->trophies()->attach($request->input('trophies'));

      return redirect(route('users.index'))->with('message', 'User created successfully.');
    }

    public function show(User $user)
    {
      return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
      return view('admin.users.edit', [
        'user' => $user,
        'trophies' => Trophy::all(),
      ]);
    }

    public function update(Request $request, User $user)
    {
      $validator = Validator::make($request->all(), [
          'name' => ['required', 'string', 'min:4', 'max:50', 'alpha_num', Rule::unique('users')->ignore($user)],
          'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
          'description' => ['nullable', 'string'],
      ])->validate();
      
      // update model
      $user->update($validator);
      
      // update related models
      $user->trophies()->sync($request->input('trophies'));
      
      return redirect(route('users.show', ['user' => $user]))->with('message', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
      $user->delete();
      return redirect(route('users.index'))->with('message', 'User deleted successfully.');
    }
}
