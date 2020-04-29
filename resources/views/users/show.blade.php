@extends('layouts.app')

@section('content')

<div class="bg-gray-300">
  <div class="container mx-auto pt-8">
    <div class="lg:flex">
      <div id="left" class="lg:w-2/3">
        
        @foreach ($user->posts as $post)
          <a href="{{ route('front.posts.show', ['community' => $post->community, 'post' => $post]) }}">
            <div class="bg-white shadow px-5 py-5 mb-5 rounded flex">
              <div class="">
                <span>↑</span><br>
                <span>7.9k</span><br>
                <span>↓</span>  
              </div>
              <div class="mx-5">
                <div class="mb-4">Publié sur <a class="hover:underline font-bold" href="{{ $post->community->deleted ? '#' : route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->deleted ? '[supprimé]' : $post->community->name }}</a>, {{ now()->diffInHours($post->created_at) }} hours ago</div>
                <div class="mb-4">{{ $post->title }}</div>
                <div class="mb-4">{{ $post->content }}</div>
                <div class="mb-4"><a href="url" class="regLink">Hello world link</a></div>
                <div>
                  <span>232 Comments</span>
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
