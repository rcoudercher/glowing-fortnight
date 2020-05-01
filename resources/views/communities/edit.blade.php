@extends('layouts.app')

@section('title', 'Modifier une communauté / Configuration')

@section('content')
  
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          
          <div class="border-solid border border-gray-400 bg-white shadow p-5 mb-5 rounded" style="font-family: 'Roboto', sans-serif;">
            
            <h1 class="title h1 mb-8">Administration de r/{{ $community->display_name }}</h1>
            
            <h2 class="title h2 mb-8">Modifier la commnauté</h2>
            <form action="{{ route('front.communities.update', ['community' => $community]) }}" method="POST">
              @method('PATCH')
              @csrf
              
              <div class="flex flex-wrap mb-6">
                <p class="text-gray-700 text-sm font-bold">Type :</p>
                <div class="px-2">
                  <input class="ml-2" type="radio" id="type1" name="type" value="1" {{ $community->type == 1 ? 'checked' : '' }}>
                  <label class="ml-1" for="type1">Public</label>
                </div>
                <div class="px-2">
                  <input class="ml-2" type="radio" id="type2" name="type" value="2" {{ $community->type == 2 ? 'checked' : '' }}>
                  <label class="ml-1" for="type2">Privé</label>
                </div>
                <div class="px-2">
                  <input class="ml-2" type="radio" id="type3" name="type" value="3" {{ $community->type == 3 ? 'checked' : '' }}>
                  <label class="ml-1" for="type3">Restreint</label>
                </div>
                @error('type')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              
              <div class="flex flex-wrap mb-6">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                <input type="title" class="bg-gray-300 form-input w-full @error('title') border-red-500 @enderror" name="title" value="{{ old('title') ?? $community->title }}">
                @error('name')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              
              
              <div class="flex flex-wrap mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea class="bg-gray-300 form-input w-full @error('name') border-red-500 @enderror" name="description" id="description" rows="4" cols="80">{{ old('description') ?? $community->description }}</textarea>
                @error('description')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              
              <div class="flex flex-wrap mb-6">
                <label for="submission_text" class="block text-gray-700 text-sm font-bold mb-2">Message pour soumissions</label>
                <textarea class="bg-gray-300 form-input w-full @error('submission_text') border-red-500 @enderror" name="submission_text" id="submission_text" rows="4" cols="80">{{ old('submission_text') ?? $community->submission_text }}</textarea>
                @error('submission_text')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              
              <button type="submit" class="btn btn-blue">Créer</button>
            </form>
            
          </div>
          
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            <a class="hover:underline" href="{{ route('front.communities.show', ['community' => $community]) }}">r/{{ $community->display_name }}</a>
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  


@endsection
