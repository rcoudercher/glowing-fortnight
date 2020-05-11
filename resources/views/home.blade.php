@extends('layouts.app')

@section('title', 'Accueil')

@section('scripts')
@endsection

@section('content')
  <div class="bg-gray-300">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          @foreach ($posts as $post)
            <div class="card post cursor-pointer" data-hash="{{ $post->hash }}" data-community="{{ $post->community->display_name }}" data-slug="{{ $post->slug }}">
              <div class="voteWrapper">
                <div class="voteBtn upVote{{ $post->upVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-up"></i></div>
                <div class="p-1 text-center">{{ $post->voteCount() }}</div>
                <div class="voteBtn downVote{{ $post->downVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-down"></i></div>
              </div>
              <div class="mx-5">
                <div class="mb-4 text-sm">
                  <a class="hover:underline font-semibold" href="{{ route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->display_name }}</a>
                   - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show.posts', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
                </div>
                <div class="mb-4">
                  <a href="{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">
                    <h3 class="title h3">{{ $post->title }}</h3>
                  </a>
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
                
                <div class="flex text-sm">
                  <div><a class="hover:underline" href="{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">{{ $post->comments->count() }} commentaires</a></div>
                  <div class="ml-4 hover:underline">Partager</div>
                  <div class="ml-4 hover:underline">Sauvegarder</div>
                </div>
                <div class="mt-2 text-sm">
                  Wilson score : {{ $post->wilsonScore() }}
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            <div>
              <div class="">
                some text
              </div>
            </div>
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
    @component('components.who')
    @endcomponent
  </div>
  <script>
    // vote buttons
    var upVoteBtns = document.getElementsByClassName("upVote");
    var downVoteBtns = document.getElementsByClassName("downVote");
    
    for (var i = 0; i < upVoteBtns.length; i++) {
      upVoteBtns.item(i).addEventListener("click", function(e) {
        var target = e.target || e.srcElement;
        vote(target, "post", "up");
        refreshVoteCounter(target, "post");
        e.stopPropagation();
      });
    }
    
    for (var i = 0; i < downVoteBtns.length; i++) {
      downVoteBtns.item(i).addEventListener("click", function(e) {
        var target = e.target || e.srcElement;
        vote(target, "post", "down");
        refreshVoteCounter(target, "post");
        e.stopPropagation();
      });
    }
    
    // links to posts
    var posts = document.getElementsByClassName("post");
    var protocol = window.location.protocol;
    var host = window.location.host;
    
    for (var i = 0; i < posts.length; i++) {
      let display_name = posts.item(i).getAttribute("data-community");
      let hash = posts.item(i).getAttribute("data-hash");
      let slug = posts.item(i).getAttribute("data-slug");
      let url = protocol + "//" + host + "/r/" + display_name + "/" + hash + "/" + slug;
      posts.item(i).addEventListener("click", function() {
        
        window.location.href=url;
      });
      
    }

  </script>
@endsection
