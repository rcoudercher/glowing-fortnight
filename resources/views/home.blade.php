@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
  <div class="bg-gray-300">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          @foreach ($posts as $post)
            <div style="font-family: 'Roboto', sans-serif;" class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow px-5 py-5 mb-5 rounded flex cursor-pointer" onclick="window.location.href='{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}'">
              <div>
                <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↑</div>
                <div class="p-1 text-center">7.9k</div>
                <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↓</div>
              </div>
              <div class="mx-5">
                <div class="mb-4 text-sm">
                  <a class="hover:underline font-semibold" href="{{ route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->display_name }}</a>
                   - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
                </div>
                <div class="mb-4">
                  <a href="{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">
                    <h3 class="title h3">{{ $post->title }}</h3>
                  </a>
                </div>
                <div class="mb-4 text-base leading-snug">{{ $post->content }}</div>
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
            <div>
              <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            </div>
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
    
    @component('components.who')
    @endcomponent
    
    
  </div>
@endsection
