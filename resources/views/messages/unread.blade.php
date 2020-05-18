@extends('layouts.message')

@section('title', 'Messages non lus / Message')

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      linkToMessage("message");
    });
  </script>
@endsection

@section('section')
  <div class="p-4">
    <h3 class="title h3 mb-4">Messages non lus</h3>
    
    @if ($messages->count() == 0)
      <p>Aucun message non lu</p>
    @else
      
      @foreach ($messages as $message)
        <div class="message card hover:border-gray-600 cursor-pointer" data-link="{{ route('messages.show', ['message' => $message]) }}">
          <p>{{ $message->title }}, de <span class="underline">u/{{ $message->sender->display_name }}</span>, le {{ $message->created_at }}. <a href="{{ route('messages.show', ['message' => $message]) }}">LIRE PLUS</a></p>
        </div>
      @endforeach
      
      
    @endif
    
    
  </div>
@endsection
