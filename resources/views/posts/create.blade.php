@extends('layouts.app')

@section('title', 'eee')

@section('content')
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          <div class="bg-white shadow px-5 py-5 mb-5 rounded">
            <div class="mb-4">
              <h2 class="title h2">Publier sur r/{{ $community->display_name }}</h2>
            </div>
            
            
            <div class="flex">
              <button class="btn btn-blue flex-grow mr-2" type="button" name="button">Texte</button>
              <button class="btn btn-blue flex-grow mr-2" type="button" name="button">Image & Vidéo</button>
              <button class="btn btn-blue flex-grow mr-2" type="button" name="button">Lien</button>
              <button class="btn btn-blue flex-grow" type="button" name="button">Sondage</button>
            </div>
            
            <div class="border-b-2 border-gray-900 my-6"></div>
            
            
            
            <div class="">
              
              <form action="{{ route('front.posts.create', ['community' => $community]) }}" method="POST">
                @csrf
                <div class="flex flex-wrap mb-6">
                  <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                  <input id="title" type="title" class="bg-gray-300 form-input w-full @error('title') border-red-500 @enderror" name="title" value="{{ old('title') ?? $post->title }}" required autofocus>
                  @error('title')
                    <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                  @enderror            
                </div>
                
                <div class="flex flex-wrap mb-6">
                  <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Contenu</label>
                  <textarea class="bg-gray-300 form-input w-full @error('name') border-red-500 @enderror" name="content" id="content" rows="4" cols="80">{{ old('content') ?? $post->content }}</textarea>
                  @error('content')
                    <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                  @enderror
                </div>
                
                

                <button type="submit" class="btn btn-blue">Save</button>
              </form>
              
            </div>
            
          </div>
        </div>
        
        
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            <div class="mb-4 title h3">r/{{ $community->display_name }}</div>
            <div>{{ $community->description }}</div>
          </div>
          @include('components.footer')
        </div>
        
        
      </div>
    </div>
    
    @component('components.who')
    @endcomponent
    
    
  </div>
@endsection
