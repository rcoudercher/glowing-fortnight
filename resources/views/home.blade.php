@extends('layouts.app')

@section('content')
  <div class="bg-gray-300">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          @foreach ($posts as $post)
            <div class="bg-white shadow px-5 py-5 mb-5 rounded flex">
              <div class="">
                <span>↑</span><br>
                <span>7.9k</span><br>
                <span>↓</span>  
              </div>
              <div class="mx-5">
                <div class="mb-4">
                  <span class="font-bold">
                    <a class="hover:underline" href="{{ route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->display_name }}</a>
                  </span>
                   - Posted by <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, {{ now()->diffInHours($post->created_at) }} hours ago
                </div>
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
