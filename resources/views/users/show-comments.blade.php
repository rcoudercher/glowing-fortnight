@extends('layouts.app')

@section('title', 'Commentaires de u/'.$user->display_name)

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
        
        @foreach ($comments as $comment)
          
          @if ($comment->isChild())
            
            <div style="font-family: 'Roboto', sans-serif;" class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow mb-5 rounded">
              <div class="border-b border-gray-400 p-4">
                u/{{ $user->display_name }} <span class="text-sm">a participé a</span> <a class="hover:underline text-blue-500" href="{{ route('posts.show', ['community' => $comment->community, 'post' => $comment->post, 'slug' => $comment->post->slug]) }}">{{ $comment->post->title }}</a>
              </div>
              <div class="border-b border-gray-400 p-4">
                <div class="mb-2">
                  <a class="hover:underline text-sm" href="{{ route('users.show.posts', ['user' => $comment->parent()->user]) }}">u/{{ $comment->parent()->user->display_name }}</a> a commenté :
                </div>
                <div class="">
                  {!! $comment->parent()->content !!}
                </div>
              </div>
              <div class="p-4 ml-6">
                {!! $comment->content !!}
              </div>
            </div>
            
          @else
            
            
            <div style="font-family: 'Roboto', sans-serif;" class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow mb-5 rounded">
              <div class="border-b border-gray-400 p-4">
                u/{{ $user->display_name }} <span class="text-sm">a participé a</span> <a class="hover:underline text-blue-500" href="{{ route('posts.show', ['community' => $comment->community, 'post' => $comment->post, 'slug' => $comment->post->slug]) }}">{{ $comment->post->title }}</a>
              </div>
              <div class="p-4">
                {!! $comment->content !!}
              </div>
            </div>
            
          @endif
          
          
          
          
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
  
  
@endsection
