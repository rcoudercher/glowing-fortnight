@extends('layouts.app')

@section('title', 'eee')

@section('content')
  
<div class="bg-gray-300 h-screen">

  
  <div class="container mx-auto pt-8">
    <div class="lg:flex">
      <div id="left" class="lg:w-2/3">
        
        
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
            <div class="flex text-sm pb-8 border-b border-gray-800">
              <div><a class="hover:underline" href="{{ route('front.posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">{{ $post->comments->count() }} commentaires</a></div>
              <div class="ml-4 hover:underline">Partager</div>
              <div class="ml-4 hover:underline">Sauvegarder</div>
            </div>
            
            <div class="mt-8 text-base leading-snug">
              @foreach ($post->comments as $comment)
                <div class="mb-4">- {{ $comment->content }}</div>
              @endforeach
            </div>
            
            
            
          </div>
          
        </div>
        
        
        
        
        {{-- <div class="bg-white shadow px-5 py-5 mb-5 rounded">
          <div class="flex">
            <div>
              <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↑</div>
              <div class="p-1 text-center">7.9k</div>
              <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↓</div>
            </div>
            <div class="mx-5">
              <div class="mb-4">
                <a class="hover:underline" href="{{ route('front.communities.show', ['community' => $community]) }}">
                  <span class="font-bold">r/{{ $post->community->display_name }}</span>
                </a>
                 - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>
                 , il y a {{ now()->diffInHours($post->created_at) }} heures</div>
              <div class="mb-4">{{ $post->title }}</div>
              <div class="mb-4">{{ $post->content }}</div>
              <div class="mb-4"><a href="url" class="regLink">Hello world link</a></div>
              <div class="mb-4">
                <span>232 Comments</span>
                <span>share</span>
                <span>save</span>
              </div>
            </div>
          </div>
          
          @foreach ($post->comments as $comment)
            <div class="mb-4">- {{ $comment->content }}</div>
            
          @endforeach
          
          
        </div> --}}
        
        
        
      </div>
      <div id="right" class="lg:ml-6 lg:w-1/3">
        <div class="bg-white shadow p-4 mb-5 rounded">
          <div>
            <div class="mb-4">r/{{ $community->display_name }}</div>
            <div>{{ $community->description }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  
  
@endsection
