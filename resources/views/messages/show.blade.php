@extends('layouts.message')

@section('title', $message->title.' / Message')

@section('scripts')
  <script type="text/javascript">
  
  window.addEventListener("DOMContentLoaded", function() {
    
    var destroyBtn = document.getElementById("destroyBtn");
    destroyBtn.addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("destroyForm").submit();
    });
    
    var markUnreadBtn = document.getElementById("markUnreadBtn");
    markUnreadBtn.addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("markUnreadForm").submit();
    });
    
    var archiveBtn = document.getElementById("archiveBtn");
    archiveBtn.addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("archiveForm").submit();
    });
  });
  
  
  </script>
@endsection

@section('section')
  <div class="p-4">
    
    @if ($message->isChild())
      @foreach ($message->ancestors() as $ancestor)
        <div class="card">
          <p class="mb-2">de <a class="link" href="{{ route('users.show.posts', ['user' => $ancestor->sender]) }}">u/{{ $ancestor->sender->display_name }}</a>, il y a {{ now()->diffInHours($ancestor->created_at) }} heures</p>
          <p>{{ $ancestor->content }}</p>
        </div>
      @endforeach
    @endif
    
    <div class="card">
      <h3 class="title h3 mb-4">{{ $message->title }}</h3>
      <p>de <a class="link" href="{{ route('users.show.posts', ['user' => $message->sender]) }}">u/{{ $message->sender->display_name }}</a>, il y a {{ now()->diffInHours($message->created_at) }} heures</p>
      <p class="mt-6">{{ $message->content }}</p>
    </div>
    <div class="flex">
      <div class=""><a class="link" href="{{ route('messages.reply', ['message' => $message]) }}">répondre</a></div>
      <div class="">
        <span id="archiveBtn" class="ml-4 link cursor-pointer">archiver</span>
        <form id="archiveForm" class="hidden" action="{{ route('messages.archive', ['message' => $message]) }}" method="post">
          @csrf
        </form>
      </div>
      
      <div class="">
        <span id="destroyBtn" class="ml-4 link cursor-pointer">supprimer</span>
        <form id="destroyForm" class="hidden" action="{{ route('messages.destroy', ['message' => $message]) }}" method="post">
          @csrf
          @method('DELETE')
        </form>
      </div>
      
      <div class="">
        <span id="markUnreadBtn" class="ml-4 link cursor-pointer">marquer comme non lu</span>
        <form id="markUnreadForm" class="hidden" action="{{ route('messages.mark-unread', ['message' => $message]) }}" method="post">
          @csrf
        </form>
      </div>
      
    </div>
  </div>
@endsection







