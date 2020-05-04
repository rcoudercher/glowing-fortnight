<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription / {{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  </head>
  <body class="antialiased leading-none">
    
    <div class="sm:flex">
      <div class="bg-blueprint-grid h-24 sm:w-1/6 sm:min-h-screen sm:p-8"></div>
      <div class="mt-8 px-8 container mx-auto" style="font-family: 'Roboto', sans-serif;">
        <div class="mb-8 flex">
          <p class="flex-grow text-xl underline"><a href="{{ route('front.home') }}">← accueil</a></p>
          <p class="text-sm">Déjà membre ? <a class="text-blue-600 hover:underline font-bold" href="{{ route('front.users.login') }}">CONNEXION</a></p>
        </div>
        <div class="max-w-lg">
          <div class="mb-5">
            <img src="https://www.redditstatic.com/accountmanager/18e257d5fdea817c0f12cccf8867d930.svg" alt="">
          </div>
          <h1 class="title h1 mb-5">Inscription</h1>
          <p class="mb-4 leading-snug">By having a Reddit account, you can join, vote, and comment on all your favorite Reddit content.</p>
          <div class="mb-6">
            <form method="POST" action="{{ route('front.users.store') }}">
              @csrf
              <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input id="email" type="email" class="form-input w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="off">
                @error('email')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-6">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur</label>
                <input id="name" type="text" class="form-input w-full @error('name') border-red-500 @enderror" name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="off">
                <p class="mt-4">Suggestions : <a class="text-blue-700 underline" href="">pierre</a>, <a class="text-blue-700 underline" href="">pierre</a>, <a class="text-blue-700 underline" href="">pierre</a>. <a class="text-blue-700 underline" href="">plus</a></p>
                @error('email')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                <input id="password" type="password" class="form-input w-full @error('password') border-red-500 @enderror" name="password" required autocomplete="off">
                @error('password')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              <div class="">
                <button type="submit" class="btn btn-blue">Inscription</button>
              </div>
            </form>
          </div>
          <div class="mb-6">
            <p class="text-sm">En continuant, vous acceptez nos <a class="text-sm text-blue-600 hover:underline" href="#">conditions générales</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
