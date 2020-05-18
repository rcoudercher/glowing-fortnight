@extends('layouts.message')

@section('title', 'Répondre / Message')

@section('section')
  <div class="p-4">
    <h1 class="title h1">Réponse à :</h1>
    <div class="card mt-6">
      <h3 class="title h3 mb-2">{{ $message->title }}</h3>
      <p>{{ $message->content }}</p>
      <p class="mt-4">de <a class="link" href="{{ route('users.show.posts', ['user' => $message->sender]) }}">u/{{ $message->sender->display_name }}</a>, le {{ $message->created_at }}</p>
    </div>
    
    
    <form class="" action="{{ route('messages.store-reply', ['message' => $message]) }}" method="POST">
      @csrf
      
      <div class="flex flex-wrap mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Réponse :</label>
        <textarea class="form-input w-full" name="message" rows="8" cols="80" autocomplete="off"></textarea>
        @error('message')
          <small class="form-text text-muted">{{ $message }}</small>
        @enderror
      </div>
      
      <div class="flex flex-wrap mb-6">
        CAPTCHA
      </div>
      
      <div class="flex flex-wrap mb-6">
        <button class="btn btn-blue" type="submit">Envoyer</button>
      </div>
      
    </form>
    
  </div>
@endsection
