@extends('layouts.app')

@section('title', 'Publications de u/'.$user->display_name)

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
  <div class="border-b border-gray-400">
    <div class="container mx-auto py-3">
      <div class="flex">
        <div class="">
          <a class="hover:underline" href="{{ route('users.show.posts', ['user' => $user]) }}">Publications</a>
        </div>
        <div class="ml-6">
          <a class="hover:underline" href="{{ route('users.show.comments', ['user' => $user]) }}">Commentaires</a>
        </div>
      </div>
    </div>
  </div>

<div class="bg-gray-300 min-h-screen">
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
                u/{{ $user->display_name }} a publié sur <a class="hover:underline font-semibold" href="{{ route('communities.show', ['community' => $post->community]) }}">k/{{ $post->community->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
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
            </div>
          </div>
          
        @endforeach
      </div>
      <div id="right" class="lg:ml-6 lg:w-1/3">
        <div class="card">
          <div class="bg-red-300">
            <h3>A propos de cet utilisateur</h3>
          </div>
          <div>
            <div class="mb-2">{{ $user->description }}</div>
            <div class="mb-2">150 followers</div>
            <div class="mb-2">Profil créé le {{ $user->created_at }}</div>
            <div>
              <span class="shadow-sm rounded-md">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
                  FOLLOW
                </button>
              </span>
              <span class="shadow-sm rounded-md">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
                  SEND MESSAGE
                </button>
              </span>
              <span class="shadow-sm rounded-md">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
                  REPORT USER
                </button>
              </span>
            </div>
          </div>
        </div>
        
        <div class="card">
          <h3 class="title h3">Trophés</h3>
          @foreach ($user->trophies as $trophy)
            
            
            <div class="flex">
              
              <div>
                {{-- <img src="{{ asset('storage/'.$trophy->image) }}" alt="{{ $trophy->name }}" class="w-20"> --}}
                <img src="{{ $trophy->image }}" alt="{{ $trophy->name }}">
                
              </div>
              <div>{{ $trophy->name }}</div>
            </div>
            
          @endforeach
        </div>
        @include('components.footer')
      </div>
    </div>
  </div>
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
