@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
  <div class="bg-gray-300 h-screen">
    <div class="container mx-auto pt-8">
    <div class="flex flex-wrap justify-center">
    <div class="w-full max-w-sm">
    <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
    Connexion
    </div>

    <form class="w-full p-6" method="POST" action="{{ route('login') }}">
    @csrf

    <div class="flex flex-wrap mb-6">
    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
    Email:
    </label>

    <input id="email" type="email" class="form-input w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

    @error('email')
    <p class="text-red-500 text-xs italic mt-4">
    {{ $message }}
    </p>
    @enderror
    </div>

    <div class="flex flex-wrap mb-6">
    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
    Mot de passe :
    </label>

    <input id="password" type="password" class="form-input w-full @error('password') border-red-500 @enderror" name="password" required>

    @error('password')
    <p class="text-red-500 text-xs italic mt-4">
    {{ $message }}
    </p>
    @enderror
    </div>

    <div class="flex mb-6">
    <label class="inline-flex items-center text-sm text-gray-700" for="remember">
    <input type="checkbox" name="remember" id="remember" class="form-checkbox" {{ old('remember') ? 'checked' : '' }}>
    <span class="ml-2">Rester connecté</span>
    </label>
    </div>

    <div class="flex flex-wrap items-center">
    <button type="submit" class="btn btn-blue">
    Connexion
    </button>

    @if (Route::has('password.request'))
    <a class="text-sm text-blue-500 hover:text-blue-700 whitespace-no-wrap no-underline ml-auto" href="{{ route('password.request') }}">
    Mot de passe oublié ?
    </a>
    @endif

    @if (Route::has('register'))
    <p class="w-full text-xs text-center text-gray-700 mt-8 -mb-4">
    Nouveau ?
    <a class="text-blue-500 hover:text-blue-700 no-underline" href="{{ route('front.users.create') }}">
    INSCRIPTION
    </a>
    </p>
    @endif
    </div>
    </form>

    </div>
    </div>
    </div>
    </div>
  </div>
@endsection
