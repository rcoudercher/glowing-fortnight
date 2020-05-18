<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Message;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Str;

class MessageController extends Controller
{
  public function inbox()
  {
    $messages = Auth::user()->receivedMessages->whereNull('archived_at')->sortByDesc('created_at');
    return view('messages.inbox', compact('messages'));
  }
  
  public function unread()
  {
    $messages = Auth::user()->unreadMessages->sortByDesc('created_at');
    return view('messages.unread', compact('messages'));
  }
  
  public function sent()
  {
    $messages = Auth::user()->sentMessages->sortByDesc('created_at');
    return view('messages.sent', compact('messages'));
  }
  
  public function archived()
  {
    $messages = Auth::user()->archivedMessages()->sortByDesc('created_at');
    return view('messages.archived', compact('messages'));
  }
  
  public function create()
  {
    return view('messages.create');
  }
  
  public function store(Request $request)
  {
    // input validation
    $data = [
      'to' => $request->input('to'),
      'subject' => $request->input('subject'),
      'message' => $request->input('message'),
    ];
    $rules = [
      'to' => ['required', 'string', 'min:4', 'max:50', 'alpha_num'],
      'subject' => ['required', 'string', 'max:100'],
      'message' => ['required', 'string', 'max:1000'],
    ];
    $messages = [
      'to.required' => 'Ce champ est obligatoire.',
      'to.min' => 'Le nom du destinataire doit faire au moins :min caractères.',
      'to.max'=> 'Le nom du destinataire ne doit pas faire plus de :max caractères.',
      'subject.required' => 'Ce champ est obligatoire.',
      'message.required' => 'Ce champ est obligatoire',
      'subject.max' => 'Le titre ne doit pas faire plus de :max caractères.',
      'message.max' => 'Le message ne doit pas faire plus de :max caractères.',
    ];
    $validator = Validator::make($data, $rules, $messages)->validate();
    
    // if all inputs are valid, find the requested user
    $name = Str::lower($request->input('to'));
    $users = User::where('name', $name)->get();
    
    if ($users->count() != 1) {
      return back()->with('error', 'aucun utilisateur trouvé avec ce nom');
    }
    
    $recipient = $users->first();
    
    // once the receiver user is found, create the new message
    $message = new Message;
    $message->hash = $this->findUniqueMessageHash();
    $message->from_id = Auth::user()->id;
    $message->to_id = $recipient->id;
    $message->title = $request->input('subject');
    $message->content = $request->input('message');
    $message->save();
    
    // trigger an event to notify the recipient
    
    return redirect(route('messages.inbox'))->with('message', 'Message envoyé');  
  }
  
  public function show(Message $message)
  {
    // dd($message->ancestors());
    
    // set a timestamp on the read_at column the first time a message is shown  
    if (is_null($message->read_at)) {
      $message->read_at = now();
      $message->save();
    }
    
    return view('messages.show', compact('message'));
  }
  
  public function reply(Message $message)
  {
    return view('messages.reply', compact('message'));
  }
  
  public function storeReply(Message $message, Request $request)
  {
    // input validation
    $data = [
      'message' => $request->input('message'),
    ];
    $rules = [
      'message' => ['required', 'string', 'max:1000'],
    ];
    $messages = [
      'message.required' => 'Ce champ est obligatoire',
      'message.max' => 'Le message ne doit pas faire plus de :max caractères.',
    ];
    $validator = Validator::make($data, $rules, $messages)->validate();
    
    // once input are validated, retrieve ancestor message
    $message->isAncestor() ? $ancestor = $message : $ancestor = $message->ancestor();
        
    // then create new message
    $reply = new Message;
    $reply->hash = $this->findUniqueMessageHash();
    $reply->from_id = Auth::user()->id;
    $reply->to_id = $message->sender->id;
    $reply->ancestor_id = $ancestor->id;
    $reply->title = 'Re: '.$ancestor->title;
    $reply->content = $request->input('message');
    $reply->save();
    
    return redirect(route('messages.inbox'))->with('message', 'Réponse envoyée');
  }
  
  public function destroy(Message $message)
  {
    $message->delete();
    return redirect(route('messages.inbox'))->with('message', 'Message supprimé');
  }
  
  public function archive(Message $message)
  {
    $message->archived_at = now();
    $message->save();
    return redirect(route('messages.inbox'))->with('message', 'Message archivé');
  }
  
  public function markUnread(Message $message)
  {
    $message->read_at = null;
    $message->save();
    return redirect(route('messages.inbox'))->with('message', 'Message marqué comme non lu');
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
