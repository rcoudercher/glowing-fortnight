@extends('layouts.app')

@section('content')
  <div id="hero" class="w-screen shadow">
    <div class="h-24 bg-red-300"></div>
    <div class="bg-white h-24">
      <div class="container mx-auto flex">
        <div>
          <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">{{ $community->title }}</h1>
          <h2>r/{{ $community->name }}</h2>
        </div>
        <div class="ml-10 my-6">
          <span class="sm:ml-3 shadow-sm rounded-md">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
              Rejoindre
            </button>
          </span>
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
                  <div class="mb-4"><span class="font-bold">r/{{ $post->community->name }}</span> - Posted by u/{{ $post->user->name }}, {{ now()->diffInHours($post->created_at) }} hours ago</div>
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
