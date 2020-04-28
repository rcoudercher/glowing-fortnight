@extends('layouts.app')

@section('content')
  
<div class="bg-gray-300 h-screen">
  <div class="container mx-auto pt-8">
    <div class="lg:flex">
      <div id="left" class="lg:w-2/3">
        
        <div class="bg-white shadow px-5 py-5 mb-5 rounded">
          <div class="flex">
            <div class="">
              <span>↑</span><br>
              <span>7.9k</span><br>
              <span>↓</span>  
            </div>
            <div class="mx-5">
              <div class="mb-4"><span class="font-bold">r/{{ $post->community->name }}</span> - Posted by <a href="{{ route('front.users.show', ['user' => $post->user]) }}">u/{{ $post->user->name }}</a>, {{ now()->diffInHours($post->created_at) }} hours ago</div>
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
          
          {{-- comments below --}}
          @foreach ($post->comments as $comment)
            <div class="mb-4">- {{ $comment->content }}</div>
            
          @endforeach
          
          
        </div>
        
        
        
      </div>
      <div id="right" class="lg:ml-6 lg:w-1/3">
        <div class="bg-white shadow p-4 mb-5 rounded">
          <div>
            <div class="mb-4">r/{{ $community->name }}</div>
            <div>{{ $community->description }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  
  
@endsection
