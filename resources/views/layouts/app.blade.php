<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') / {{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  </head>
  <body class="antialiased leading-none">
    <nav class="bg-blue-900 shadow py-5">
      <div class="container mx-auto px-6 md:px-0">
        <div class="flex items-center justify-center">
          <div class="mr-6">
            <a href="{{ route('front.home') }}" class="text-lg font-semibold text-gray-100 no-underline">{{ config('app.name', 'REDDIT') }}</a>
          </div>
          <div class="flex-1">
            <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('admin.dashboard') }}">ADMIN</a>
            <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('front.communities.index') }}">Communautés</a>
            
          </div>
          <div class="flex-1 text-right">
            @guest              
              <a id="loginBtn" class="no-underline hover:underline text-gray-300 text-sm p-3 cursor-pointer">Connexion</a>
            @if (Route::has('register'))
              <a class="no-underline hover:underline text-gray-300 text-sm p-3 cursor-pointer" href="{{ route('front.users.create') }}">Inscription</a>
            @endif
            @else
              {{-- dropdown menu with options if user is logged in --}}
              <div class="relative inline-block text-left">
                <div>
                  <span class="rounded-md shadow-sm">
                    <button onclick="dropdown()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
                      {{ Auth::user()->display_name }}
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
                      <a href="{{ route('front.settings.account') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Configuration</a>                      
                    </div>
                    <div class="border-t border-gray-100"></div>
                    <div class="py-1">
                      <a href="{{ route('front.users.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Déconnexion</a>
                      <form id="logout-form" action="{{ route('front.users.logout') }}" method="POST" class="hidden">{{ csrf_field() }}</form>
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
      <div id="notif-container" class="absolute top-0 right-0 mr-5 mt-24 w-1/4">
        <div class="py-3 pl-6 pr-3 rounded-lg bg-green-300 shadow-lg mb-4">
          <div class="flex items-center justify-between flex-wrap">
            <div class="w-full flex-1 flex items-center sm:w-0">
              <p class="text-green-900">{{ session()->get('message') }}</p>
            </div>
            <div class="flex-shrink-0">
                <div class="rounded-md shadow-sm closeX cursor-pointer">
                  <span class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">X</span>
                </div>
              </div>
          </div>
        </div>
      </div>
    @endif
    
    @if (session()->has('error'))
      <div id="notif-container" class="absolute top-0 right-0 mr-5 mt-24 w-1/4">
        <div class="py-3 pl-6 pr-3 rounded-lg bg-red-300 shadow-lg mb-4">
          <div class="flex items-center justify-between flex-wrap">
            <div class="w-full flex-1 flex items-center sm:w-0">
              <p class="text-green-red">{{ session()->get('error') }}</p>
            </div>
            <div class="flex-shrink-0">
                <div class="rounded-md shadow-sm closeX cursor-pointer">
                  <span class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">X</span>
                </div>
              </div>
          </div>
        </div>
      </div>
    @endif
    
    @include('components.modals.login')
    
    @yield('content')
    
    
    <script>
    // Get the modal
    var loginModal = document.getElementById("loginModal");    

    // Get the button that opens the modal
    var loginBtn = document.getElementById("loginBtn");    

    // Get the <span> element that closes the modal
    var closeLogin = document.getElementById("closeLogin");    

    // When the user clicks the button, open the modal 
    loginBtn.onclick = function() {
      loginModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    closeLogin.onclick = function() {
      loginModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == loginModal) {
      loginModal.style.display = "none";
      }
    }
    </script>
    
    @if($errors->has('email') || $errors->has('password'))
      <script>
        var loginModal = document.getElementById("loginModal");
        loginModal.style.display = "block";
      </script>
    @endif
    
  

    
    
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
    <script>
    // close notifications
      var remove = function(){
        this.parentNode.parentNode.parentNode.remove();
      };
      var closeX = document.querySelectorAll('div.closeX');
      for (var i = 0, len = closeX.length; i < len; i++) {
        closeX[i].addEventListener('click', remove, false);
      }
      // make notifications disappear by themselves after 4 seconds
      setTimeout(function(){    
        for (var i = 0, len = closeX.length; i < len; i++) {
          closeX[i].parentNode.parentNode.parentNode.remove();
        }
        
      }, 4000);
    </script>
  </body>
</html>
