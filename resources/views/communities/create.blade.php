@extends('layouts.settings')

@section('title', 'Créer une communauté / Configuration')

@section('section-title', 'Créer une communauté')

@section('section')
  
  
  
  <div class="h-screen">
    <h2 class="title h1 mb-8">Créer une nouvelle commnauté</h2>
    <form action="{{ route('front.communities.store') }}" method="POST">
      @csrf
      
      
      <div class="flex flex-wrap mb-6">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom *</label>
        <input id="name" type="name" class="bg-gray-300 form-input w-full @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
          <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
        @enderror
        
        <p class="py-2">Le nom doit être composé uniquement de lettres ou de chiffres.</p>
        <p class="py-2">Attention, une fois choisi, le nom de la communauté ne pourra plus être modifié.</p>
        
      </div>
      
      <div class="flex flex-wrap mb-6">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea class="bg-gray-300 form-input w-full @error('name') border-red-500 @enderror" name="description" id="description" rows="4" cols="80">{{ old('description') ?? $community->description }}</textarea>
        @error('description')
          <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
        @enderror
        <p class="py-2">Décrivez votre communauté en quelques mots.</p>
      </div>
      
      

      <button type="submit" class="btn btn-blue">Créer</button>
    </form>
  </div>
  

  

@endsection
