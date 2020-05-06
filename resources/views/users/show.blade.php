@extends('layouts.app')

@section('title', 'Membre')

@section('content')

<div class="bg-gray-300 min-h-screen">
  <div class="container mx-auto pt-8">
    <div class="lg:flex">
      <div id="left" class="lg:w-2/3">
        
        @foreach ($user->posts as $post)
          
          
          <div style="font-family: 'Roboto', sans-serif;" class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow px-5 py-5 mb-5 rounded flex cursor-pointer" onclick="window.location.href='{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}'">
            <div>
              <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↑</div>
              <div class="p-1 text-center">7.9k</div>
              <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↓</div>
            </div>
            <div class="mx-5">
              <div class="mb-4 text-sm">
                Publié sur <a class="hover:underline font-semibold" href="{{ route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
              </div>
              <div class="mb-4">
                <a href="{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">
                  <h3 class="title h3">{{ $post->title }}</h3>
                </a>
              </div>
              
              @switch($post->type)
                @case(1)
                  <div class="mb-4 text-base leading-snug">{{ $post->content }}</div>
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
        
        <div class="bg-white shadow p-4 mb-5 rounded">
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
  
  
@endsection
