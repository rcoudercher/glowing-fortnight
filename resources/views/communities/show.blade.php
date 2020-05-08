@extends('layouts.app')

@section('content')
  
  <div id="hero" class="bg-white w-screen shadow">
    <div class="container mx-auto flex py-6">
      <div class="">
        <img class="rounded-full w-20" src="https://styles.redditmedia.com/t5_2qh1o/styles/communityIcon_vzx333xor7101.png" alt="">
      </div>
      <div class="ml-8" style="font-family: 'Roboto', sans-serif;">
        <h1 class="title h1">{{ $community->title ?? $community->display_name }}</h1>
        <h2 class="title h2 mt-4">r/{{ $community->display_name }}</h2>
      </div>
      <div class="ml-8">
        @guest
          {{--  should link directly to the login instead of just attempting to join as guest ? --}}
          <a class="btn btn-black" href="{{ route('front.communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
            document.getElementById('destroy-form').submit();">Rejoindre</a>
          <form id="destroy-form" action="{{ route('front.communities.join', ['community' => $community]) }}" method="POST" class="hidden">
            @csrf
          </form>
        @endguest
        
        @auth
          @if ($community->users->contains(Auth::user()))            
            <a class="btn btn-black" onmouseover="leave(this)" onmouseout="member(this)" href="{{ route('front.communities.leave', ['community' => $community]) }}" onclick="event.preventDefault(); 
              document.getElementById('destroy-form').submit();">Membre</a>
            <form id="destroy-form" action="{{ route('front.communities.leave', ['community' => $community]) }}" method="POST" class="hidden">
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
            
            <a class="btn btn-black" href="{{ route('front.communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
              document.getElementById('destroy-form').submit();">Rejoindre</a>
            <form id="destroy-form" action="{{ route('front.communities.join', ['community' => $community]) }}" method="POST" class="hidden">
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
          
          {{-- post sthg to the community --}}
          <div class="bg-white shadow px-5 py-5 mb-5 rounded flex">
            <input type="text" value="Publier un message" onclick="window.location.href='{{ route('front.posts.create', ['community' => $community]) }}'" class="hover:border-solid hover:border-blue-800 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
          </div>
          
          {{-- filter the community --}}
          <div class="bg-white shadow px-5 py-5 mb-5 rounded flex">
            various filters
          </div>
          
          @foreach ($community->posts as $post)
            
            
            <div style="font-family: 'Roboto', sans-serif;" class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow px-5 py-5 mb-5 rounded flex cursor-pointer" onclick="window.location.href='{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}'">
              <div>
                <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↑</div>
                <div class="p-1 text-center">7.9k</div>
                <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↓</div>
              </div>
              <div class="mx-5">
                <div class="mb-4 text-sm">
                  Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show.posts', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
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
                  <div><a class="hover:underline" href="{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">{{ $post->comments->count() }} commentaires</a></div>
                  <div class="ml-4 hover:underline">Partager</div>
                  <div class="ml-4 hover:underline">Sauvegarder</div>
                </div>
              </div>
            </div>
            

          @endforeach
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            <div class="bg-red-300">
              <h3>A propos de r/{{ $community->display_name }}</h3>
            </div>
            <div>
              <div class="mb-2">{{ $community->description }}</div>
              <div class="mb-2">{{ $community->users->count() }} membres</div>
              <div class="mb-2">15 membres en ligne</div>
              <div class="mb-2">community créé le {{ $community->created_at }}</div>
              <div><a href="#" class="btn btn-indigo">Publier un message</a></div>
            </div>
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  
  

  
  
@endsection
