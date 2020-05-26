<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>@yield('title') - ADMIN</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}">ADMIN</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Models
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('admin.comments.index') }}">Comments</a>
              <a class="dropdown-item" href="{{ route('admin.communities.index') }}">Communities</a>
              <a class="dropdown-item" href="{{ route('admin.memberships.index') }}">Memberships</a>
              <a class="dropdown-item" href="{{ route('admin.messages.index') }}">Messages</a>
              <a class="dropdown-item" href="{{ route('admin.posts.index') }}">Posts</a>
              <a class="dropdown-item" href="{{ route('admin.community-rules.index') }}">Rules</a>
              <a class="dropdown-item" href="{{ route('admin.trophies.index') }}">Trophies</a>
              <a class="dropdown-item" href="{{ route('admin.users.index') }}">Users</a>
            </div>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Moderation <span class="badge badge-danger">{{ App\Comment::pending()->count() + DB::table('community_user')->where('status', 0)->count() + App\Post::pending()->count() }}</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('admin.moderation.comments') }}">Comments <span class="badge badge-danger">{{ App\Comment::pending()->count() }}</span></a>
              <a class="dropdown-item" href="{{ route('admin.moderation.memberships') }}">Memberships <span class="badge badge-danger">{{ DB::table('community_user')->where('status', 0)->count() }}</span></a>
              <a class="dropdown-item" href="{{ route('admin.moderation.posts') }}">Posts <span class="badge badge-danger">{{ App\Post::pending()->count() }}</span></a>
            </div>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">// FRONT //</a></li>
        </ul>
        {{-- <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> --}}
      </div>
      {{-- login links --}}
      <ul class="navbar-nav mr-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
            @if (Route::has('register'))
              <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
            @endif
        @else
          <span class="navbar-text">{{ Auth::user()->name }}</span>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); 
            document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
          </li>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
            {{ csrf_field() }}
          </form>
        @endguest
      </ul>
    </nav>
    <div class="container mt-4 mb-4">
      @if (session()->has('message'))
        <div class="alert alert-success mt-3" role="alert">
          <strong>{{ session()->get('message') }}</strong>
        </div>
      @endif
      @if($errors->first('query'))
        <div class="alert alert-warning mt-3" role="alert">
          {{ $errors->first('query') }}
        </div>
      @endif
      @yield('content')
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
