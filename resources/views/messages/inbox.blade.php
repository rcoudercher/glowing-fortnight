@extends('layouts.message')

@section('title', 'Boîte de réception / Message')

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      linkToMessage("message");
    });
  </script>
@endsection

@section('section')
  <div class="p-4">
    <h3 class="title h3 mb-4">Boîte de réception</h3>
    
    
    @if ($messages->count() == 0)
      <p>Aucun message</p>
    @else
      
      @foreach ($messages as $message)
        <div class="message card hover:border-gray-600 cursor-pointer" data-link="{{ route('messages.show', ['message' => $message]) }}">
          <p>@if ($message->isUnread()) <span class="text-blue-600 font-extrabold">unread </span> @endif {{ $message->title }}, de <span class="underline">u/{{ $message->sender->display_name }}</span>, le {{ $message->created_at }}. <a href="{{ route('messages.show', ['message' => $message]) }}">LIRE PLUS</a></p>
        </div>
      @endforeach
      
      
    @endif
    
    
    
    
  </div>
@endsection
