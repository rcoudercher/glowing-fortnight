@extends('layouts.app')

@section('title', 'Accueil')

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      toggleShareOptionsDropdown();
      copyPostLinkToClipboard();
      addCardLinksToPosts();
    });
  </script>
@endsection

@section('content')
  <div class="bg-gray-300">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          @foreach ($posts as $post)
            <div class="card flex post wrapper cursor-pointer" data-hash="{{ $post->hash }}" data-community="{{ $post->community->display_name }}" data-slug="{{ $post->slug }}">
              <div class="">
                <div class="voteBtn upVote arrowUp {{ $post->upVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-up"></i></div>
                <div class="p-1 text-center"><span class="counter">{{ $post->voteCount() }}</span></div>
                <div class="voteBtn downVote arrowDown {{ $post->downVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-down"></i></div>
              </div>
              <div class="mx-5">
                <div class="mb-4 text-sm">
                  <a class="hover:underline font-semibold" href="{{ route('communities.show', ['community' => $post->community]) }}">k/{{ $post->community->display_name }}</a>
                   - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('users.show.posts', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
                </div>
                <div class="mb-4">
                  <a href="{{ route('posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">
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
                  <div><a class="hover:underline" href="{{ route('posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">{{ $post->comments->count() }} commentaires</a></div>
                  <div class="relative inline-block text-left">
                    <div class="ml-4 hover:underline shareBtn">Partager</div>
                    <div class="wrapper origin-top-left absolute left-0 mt-2 w-40 rounded-md shadow-lg hidden">
                      <div class="rounded-md bg-white shadow-xs">
                        <div class="py-1">
                          <span data-link="{{ route('posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}" class="copyLinkBtn block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">copier lien</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ml-4 hover:underline">Sauvegarder</div>
                </div>
                <div class="mt-2 text-sm">Wilson score : {{ $post->wilsonScore() }}</div>
              </div>
            </div>
          @endforeach
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="card">
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
  </script>
@endsection
