@extends('layouts.app')

@section('content')
  <div class="container mx-auto mt-8 border-b-2">
    
    <div class="mb-8">
      <h1 class="title h1 mb-4">Configuration</h1>
      <h2 class="title h2 mb-4">@yield('section-title')</h2>
      <ul class="flex">
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('front.users.settings.account') }}">Compte</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('front.users.settings.profile') }}">Profil</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('front.users.settings.privacy') }}">Sécurité</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('front.users.settings.feed') }}">Flux</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('front.users.settings.notifications') }}">Notifications</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('front.users.settings.messaging') }}">Messagerie</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('front.users.settings.communities') }}">Communautés</a>
        </li>
        
      </ul>
    </div>
  </div>
  <div class="container mx-auto mt-8">
    @yield('section')
  </div>
@endsection
