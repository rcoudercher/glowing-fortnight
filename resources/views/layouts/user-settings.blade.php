@extends('layouts.app')

@section('content')
  <div class="container mx-auto mt-8 border-b-2">
    
    @if (session()->has('message'))
      <div class="shadow rounded p-4 my-4 bg-green-300">
        <div class="text-green-900 text-center"><strong>{{ session()->get('message') }}</strong></div>
      </div>
    @endif
    
    @if (session()->has('error'))
      <div class="shadow rounded p-4 my-4 bg-red-300">
        <div class="text-red-900 text-center"><strong>{{ session()->get('error') }}</strong></div>
      </div>
    @endif
    
    <div class="mb-8">
      <h1 class="title h1 mb-4">Configuration</h1>
      <h2 class="title h2 mb-4">@yield('section-title')</h2>
      <ul class="flex">
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('user.settings.account') }}">Compte</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('user.settings.profile') }}">Profil</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('user.settings.privacy') }}">Sécurité</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('user.settings.feed') }}">Flux</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('user.settings.notifications') }}">Notifications</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('user.settings.messaging') }}">Messagerie</a>
        </li>
        <li class="mr-6">
          <a class="text-blue-500 hover:text-blue-800" href="{{ route('user.settings.communities.index') }}">Communautés</a>
        </li>
        
      </ul>
    </div>
  </div>
  <div class="container mx-auto mt-8">
    @yield('section')
  </div>
@endsection
