@extends('layouts.app')

@section('title', $community->display_name)

@section('scripts')
  <script type="text/javascript">
  
  
  window.addEventListener("DOMContentLoaded", function() {
    
    toggleShareOptionsDropdown();
    copyPostLinkToClipboard();
    addCardLinksToPosts();
    toggleCommunityRuleDescription();
    
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
    
  });
  
  
  </script>
@endsection

@section('content')
  
  <div id="hero" class="bg-white w-screen shadow">
    <div class="container mx-auto flex py-6">
      <div class="">
        <img class="rounded-full w-20" src="https://styles.redditmedia.com/t5_2qh1o/styles/communityIcon_vzx333xor7101.png" alt="">
      </div>
      <div class="ml-8" style="font-family: 'Roboto', sans-serif;">
        <h1 class="title h1">{{ $community->title ?? $community->display_name }}</h1>
        <h2 class="title h2 mt-4">k/{{ $community->display_name }}</h2>
      </div>
      <div class="ml-8">
        
        @if (!is_null(Auth::user()) && $community->isAdmin(Auth::user()))
          <a class="btn btn-blue mr-6" href="{{ route('communities.admin.dashboard', ['community' => $community]) }}">admin</a>
        @endif
        
        @guest
          {{--  should link directly to the login instead of just attempting to join as guest ? --}}
          <a class="btn btn-black" href="{{ route('communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
            document.getElementById('destroy-form').submit();">Rejoindre</a>
          <form id="destroy-form" action="{{ route('communities.join', ['community' => $community]) }}" method="POST" class="hidden">
            @csrf
          </form>
        @endguest
        
        @auth
          @if ($community->users->contains(Auth::user()))            
            <a class="btn btn-black" onmouseover="leave(this)" onmouseout="member(this)" href="{{ route('communities.leave', ['community' => $community]) }}" onclick="event.preventDefault(); 
              document.getElementById('destroy-form').submit();">Membre</a>
            <form id="destroy-form" action="{{ route('communities.leave', ['community' => $community]) }}" method="POST" class="hidden">
              @csrf
            </form>
            
            <script>
              function leave(x) {
                x.innerHTML = "Quitter";
              }
              function member(x) {
                x.innerHTML = "Membre";
              }
            </script>
          @else
            {{-- a user is logged in but not a member of this community yet --}}
            
            <a class="btn btn-black" href="{{ route('communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
              document.getElementById('destroy-form').submit();">Rejoindre</a>
            <form id="destroy-form" action="{{ route('communities.join', ['community' => $community]) }}" method="POST" class="hidden">
              @csrf
            </form>
            
          @endif
        @endauth
      </div>
      
    </div>
  </div>
  
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          <div class="card flex">
            <input type="text" value="Publier un message" onclick="window.location.href='{{ route('posts.create', ['community' => $community]) }}'" class="hover:border-solid hover:border-blue-800 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
          </div>
          <div class="card flex">various filters</div>
          @if ($posts->count() == 0)
            <div class="card">
              no posts in this comunity yet
            </div>
          @else
            @foreach ($posts as $post)
              
              <div class="card flex post wrapper cursor-pointer" data-hash="{{ $post->hash }}" data-community="{{ $post->community->display_name }}" data-slug="{{ $post->slug }}">
                <div class="">
                  <div class="voteBtn upVote arrowUp {{ $post->upVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-up"></i></div>
                  <div class="p-1 text-center"><span class="counter">{{ $post->voteCount() }}</span></div>
                  <div class="voteBtn downVote arrowDown {{ $post->downVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-down"></i></div>
                </div>
                <div class="mx-5">
                  <div class="mb-4 text-sm">
                    Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('users.show.posts', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
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
                        <img src="{{ $post->image }}" alt="">
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
                  <div class="mt-2 text-sm">
                    Wilson score : {{ $post->wilsonScore() }}
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="card">
            <div class="bg-red-300">
              <h3>A propos de k/{{ $community->display_name }}</h3>
            </div>
            <div>
              <div class="mb-2">{{ $community->description }}</div>
              <div class="mb-2">
                @switch($community->type)
                  @case(1)
                    <span title="Tout le monde a accès au contenu de la communauté et tout le monde peut participer.">Communauté publique</span>
                    @break
                  @case(2)
                    <span title="Tout le monde a accès au contenu de la communauté mais seuls les membres peuvent participer.">Communauté restreinte</span>
                    @break
                  @case(3)
                    <span title="Seuls les membres ont accès au contenu de la communauté et peuvent y participer.">Communauté privée</span>
                    @break
                @endswitch
              </div>
              <div class="mb-2">{{ $community->users->count() }} membres</div>
              <div class="mb-2">communauté créée le {{ $community->created_at }}</div>
              <div><a href="#" class="btn btn-indigo">Publier un message</a></div>
            </div>
          </div>
          @include('components.community-rules')
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  
@endsection
