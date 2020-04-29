@extends('layouts.app')

@section('content')
  <div id="hero" class="w-screen shadow">
    <div class="h-24 bg-red-300"></div>
    <div class="bg-white h-24">
      <div class="container mx-auto flex">
        <div>
          <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">{{ $community->title }}</h1>
          <h2>r/{{ $community->display_name }}</h2>
        </div>
        <div class="ml-10 my-6">
          
          
          @guest
            {{--  should link directly to the ogin instead of just attempting to join as guest ? --}}
            
            <a class="nav-link" href="{{ route('front.communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
              document.getElementById('destroy-form').submit();">
                <button type="button" name="button" class="btn btn-blue">Rejoindre</button>
              </a>
            <form id="destroy-form" action="{{ route('front.communities.join', ['community' => $community]) }}" method="POST" class="hidden">
              @csrf
            </form>
          @endguest
          
          @auth
            @if ($isMember)
              {{-- a user is logged in but is already a member of this community --}}
              
              <a class="nav-link" href="{{ route('front.communities.leave', ['community' => $community]) }}" onclick="event.preventDefault(); 
                document.getElementById('destroy-form').submit();">
                  <button type="button" name="button" class="btn btn-blue" onmouseover="leave(this)" onmouseout="member(this)">Membre</button>
                </a>
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
              
              <a class="nav-link" href="{{ route('front.communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
                document.getElementById('destroy-form').submit();">
                  <button type="button" name="button" class="btn btn-blue">Rejoindre</button>
                </a>
              <form id="destroy-form" action="{{ route('front.communities.join', ['community' => $community]) }}" method="POST" class="hidden">
                @csrf
              </form>
              
            @endif
            
          @endauth
          
          
          
        </div>
      </div>
    </div>
    {{-- <div>hero links</div> --}}
  </div>
  
  <div class="bg-gray-300">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          
          {{-- post sthg to the community --}}
          <div class="bg-white shadow px-5 py-5 mb-5 rounded flex">
            <input type="text" value="Create Post" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
          </div>
          
          {{-- filter the community --}}
          <div class="bg-white shadow px-5 py-5 mb-5 rounded flex">
            various filters
          </div>
          
          @foreach ($community->posts as $post)
            <a href="{{ route('front.posts.show', ['community' => $community, 'post' => $post]) }}">
              <div class="bg-white shadow px-5 py-5 mb-5 rounded flex">
                <div class="">
                  <span>↑</span><br>
                  <span>7.9k</span><br>
                  <span>↓</span>  
                </div>
                <div class="mx-5">
                  <div class="mb-4">Publié par <a  class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures</div>
                  <div class="mb-4">{{ $post->title }}</div>
                  <div class="mb-4">{{ $post->content }}</div>
                  <div class="mb-4"><a href="url" class="regLink">Hello world link</a></div>
                  <div>
                    <span>{{ $post->comments->count() }} Comments</span>
                    <span>share</span>
                    <span>save</span>
                  </div>
                </div>
              </div>
            </a>
          @endforeach
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            <div class="bg-red-300">
              <h3>A propos de ce community</h3>
            </div>
            <div>
              <div class="mb-2">{{ $community->description }}</div>
              <div class="mb-2">150 membres</div>
              <div class="mb-2">15 membres en ligne</div>
              <div class="mb-2">community créé le {{ $community->created_at }}</div>
              <div>
                <span class="shadow-sm rounded-md">
                  <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
                    CREATE POST
                  </button>
                </span>
              </div>
            </div>
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  
  

  
  
@endsection
