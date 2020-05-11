@extends('layouts.app')

@section('title', 'rrr')

@section('scripts')
  <script src="{{ asset('js/functions.js') }}" type="text/javascript"></script>
@endsection

@section('content')
  <div class="container mx-auto mt-6">
    
    
    <div class="flex">
      <div class="voteWrapper" data-post="{{ $post->hash }}">
        <div class="voteBtn" id="up"><i class="fas fa-arrow-up"></i></div>
        <div class="p-1 text-center" id="counter">{{ $post->voteCount() }}</div>
        <div class="voteBtn" id="down"><i class="fas fa-arrow-down"></i></div>
      </div>
      <div class="mx-5">
        <div class="mb-4 text-sm">
          <a class="hover:underline font-semibold" href="{{ route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->display_name }}</a>
           - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show.posts', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
        </div>
        <div class="mb-4">
          <h3 class="title h3">{{ $post->title }}</h3>
        </div>
        
        @switch($post->type)
          @case(1)
            <div class="mb-4 text-base leading-snug">{!! $post->content !!}</div>
          @break
          @case(2)
            <div class="mb-4 text-base leading-snug">
              <img src="{{ $post->image }}">
            </div>
          @break
          @case(3)
            <div class="mb-4 text-base leading-snug">
              <a class="text-blue-800 underline" href="{{ $post->link }}" rel="nofollow">{{ $post->link }}</a>
            </div>
          @break
        @endswitch
        
        
        <div class="flex text-sm pb-8">
          <div>{{ $post->comments->count() }} commentaires</div>
          <div class="ml-4 hover:underline">Partager</div>
          <div class="ml-4 hover:underline">Sauvegarder</div>
        </div>
      </div>
    </div>
    
    
  </div>
  
  
  
  <script>
    var up = document.getElementById('up');
    var down = document.getElementById('down');
    
    up.addEventListener('click', function(e) {
      var target = e.target || e.srcElement;
      postVote(target, 'up');
      refreshVoteCounter(target);
    });
    
    down.addEventListener('click', function(e) {
      var target = e.target || e.srcElement;
      postVote(target, 'down');
      refreshVoteCounter(target);
    });
  </script>
  
@endsection
