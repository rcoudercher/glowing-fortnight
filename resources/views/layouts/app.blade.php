<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') / {{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  </head>
  <body class="antialiased leading-none">
    <nav class="bg-blue-900 shadow py-5">
      <div class="container mx-auto px-6 md:px-0">
        <div class="flex items-center justify-center">
          <div class="mr-6">
            <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">{{ config('app.name', 'REDDIT') }}</a>
          </div>
          <div class="flex-1">
            <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('admin.dashboard') }}">ADMIN</a>
          </div>
          <div class="flex-1 text-right">
            @guest
              <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
            @if (Route::has('register'))
              <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
            @else
              {{-- dropdown menu with options if user is logged in --}}
              <div class="relative inline-block text-left">
                <div>
                  <span class="rounded-md shadow-sm">
                    <button onclick="dropdown()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
                      {{ Auth::user()->name }}
                      <svg class="-mr-1 ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                      </svg>
                    </button>
                  </span>
                </div>
                <div id="dropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg hidden">
                  <div class="rounded-md bg-white shadow-xs">
                    <div class="py-1">
                      <a href="{{ route('front.users.show', ['user' => Auth::user()]) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Mon Profil</a>
                      <a href="{{ route('user.settings.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Configuration</a>
                    </div>
                    <div class="border-t border-gray-100"></div>
                    <div class="py-1">
                      <a href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">{{ __('Logout') }}</a>
                      <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="hidden">{{ csrf_field() }}</form>
                    </div>
                  </div>
                </div>
              </div>
            @endguest
          </div>
        </div>
      </div>
    </nav>
    
    @if (session()->has('message'))
      <div class="bg-gray-300">
        <div class="container mx-auto">
          <div class="shadow rounded p-4 bg-green-300">
            <div class="text-green-900 text-center"><strong>{{ session()->get('message') }}</strong></div>
          </div>
        </div>
    @endif
    
    @if (session()->has('error'))
      <div class="bg-gray-300">
        <div class="container mx-auto pt-8">
          <div class="shadow rounded p-4 bg-red-300">
            <div class="text-red-900 text-center"><strong>{{ session()->get('error') }}</strong></div>
          </div>
        </div>
      </div>
    @endif
    
    
    
    @yield('content')
    <script>
      // show/hide dropdown menu
      function dropdown() {
        var x = document.getElementById("dropdown");
        if (x.classList.contains("hidden")) {
          x.classList.remove("hidden");
        } else {        
          x.classList.add("hidden");
        }
      }
    </script>
  </body>
</html>
