@extends('layouts.message')

@section('title', 'Nouveau message / Message')

@section('section')
  <div class="p-4">
    <h1 class="title h1 mb-6">Envoyer un message privé</h1>
    <form class="" action="{{ route('messages.store') }}" method="POST">
      @csrf
      
      <div class="flex flex-wrap mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="to">À</label>
        <input class="form-input w-full" type="text" name="to" autocomplete="off">
        @error('to')
          <small class="form-text text-muted">{{ $message }}</small>
        @enderror
      </div>
      
      <div class="flex flex-wrap mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="subject">Sujet</label>
        <input class="form-input w-full" type="text" name="subject" autocomplete="off">
        @error('subject')
          <small class="form-text text-muted">{{ $message }}</small>
        @enderror
      </div>
      
      <div class="flex flex-wrap mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Message</label>
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
