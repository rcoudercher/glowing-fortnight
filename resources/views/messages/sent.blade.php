@extends('layouts.message')

@section('title', 'Messages envoyés / Message')

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      linkToMessage("message");
    });
  </script>
@endsection

@section('section')
  <div class="p-4">
    <h3 class="title h3 mb-4">Messages envoyés</h3>
    
    @if ($messages->count() == 0)
      <p>Aucun message envoyé</p>
    @else
      
      @foreach ($messages as $message)
        <div class="message card hover:border-gray-600 cursor-pointer" data-link="{{ route('messages.show', ['message' => $message]) }}">
          <p>{{ $message->title }}, a <span class="underline">u/{{ $message->receiver->display_name }}</span>, le {{ $message->created_at }}. <a href="{{ route('messages.show', ['message' => $message]) }}">LIRE PLUS</a></p>
        </div>
      @endforeach
      
      
    @endif
    
    
    
  </div>
@endsection
