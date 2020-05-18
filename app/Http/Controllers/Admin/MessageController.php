<?php

namespace App\Http\Controllers\Admin;

use App\Message;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MessageController extends Controller
{
  public function index()
  {
    $messages = Message::paginate(200);
    return view('admin.messages.index', compact('messages'));
  }

  public function create()
  {
    $message = new Message(); // passes an empty model to the view
    $users = User::all();
    return view('admin.messages.create', compact('message', 'users'));
  }

  public function store(Request $request)
  {
    $data = [
      'from_id' => $request->input('from_id'),
      'to_id' => $request->input('to_id'),
      'title' => $request->input('title'),
      'content' => $request->input('content'),
    ];
    $rules = [
      'from_id' => ['required', 'integer', 'exists:App\User,id'],
      'to_id' => ['required', 'integer', 'exists:App\User,id'],
      'title' => ['required', 'string', 'max:100'],
      'content' => ['required', 'string', 'max:1000'],
    ];
    $validator = Validator::make($data, $rules)->validate();
    
    $validator['hash'] = $this->findUniqueMessageHash(); 
    
    $message = Message::create($validator);
      
    return redirect(route('admin.messages.show', ['message' => $message]))
    ->with('message', 'Message created successfully');
  }

  public function show(Message $message)
  {
    return view('admin.messages.show', compact('message'));
  }

  public function edit(Message $message)
  {
    $users = User::all();
    return view('admin.messages.edit', compact('message', 'users'));
  }

  public function update(Request $request, Message $message)
  {
    $data = [
      'from_id' => $request->input('from_id'),
      'to_id' => $request->input('to_id'),
      'title' => $request->input('title'),
      'content' => $request->input('content'),
    ];
    $rules = [
      'from_id' => ['required', 'integer', 'exists:App\User,id'],
      'to_id' => ['required', 'integer', 'exists:App\User,id'],
      'title' => ['required', 'string', 'max:100'],
      'content' => ['required', 'string', 'max:1000'],
    ];
    $validator = Validator::make($data, $rules)->validate();
    
    $message->update($validator);
    
    // return view
    return redirect(route('admin.messages.show', ['message' => $message]))
    ->with('message', 'Message updated successfully.');
  }

  public function destroy(Message $message)
  {
    $message->delete();
    return redirect(route('admin.messages.index'))
    ->with('message', 'Message deleted successfully.');
  }
  
  private function findUniqueMessageHash()
  {
    $hashes = Message::all()->pluck('hash');
    $hash = Str::random(12);
    while ($hashes->contains($hash)) {
      $hash = Str::random(12);
    }    
    return $hash;
  }
}
