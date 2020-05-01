@extends('layouts.app')

@section('content')
  
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          
          
          <div class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow p-5 mb-5 rounded" style="font-family: 'Roboto', sans-serif;">
            @foreach ($communities as $community)
              <div class="py-5 border-b-2 border-gray-500">
                <div class="flex mb-3">
                  <h3 class="title h3 hover:underline flex-grow">
                    <a href="{{ route('front.communities.show', ['community' => $community]) }}">r/{{ $community->name }}: {{ substr($community->title, 0, 40) }}</a>
                  </h3>
                  <div>
                    @guest                      
                      <a class="btn-xsm btn-black" href="{{ route('front.communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
                        document.getElementById('join-community-form-{{ $loop->iteration }}').submit();">Rejoindre</a>
                      <form id="join-community-form-{{ $loop->iteration }}" action="{{ route('front.communities.join', ['community' => $community]) }}" method="POST" class="hidden">
                        @csrf
                      </form>
                    @endguest
                    @auth
                      @if ($community->users->contains(Auth::user()))
                        <a class="btn-xsm btn-green" onmouseover="leave(this)" onmouseout="member(this)" href="{{ route('front.communities.leave', ['community' => $community]) }}" onclick="event.preventDefault();
                          document.getElementById('leave-community-form-{{ $loop->iteration }}').submit();">Membre</a>
                        <form id="leave-community-form-{{ $loop->iteration }}" action="{{ route('front.communities.leave', ['community' => $community]) }}" method="POST" class="hidden">
                          @csrf
                        </form>
                      @else
                        <a class="btn-xsm btn-black" href="{{ route('front.communities.join', ['community' => $community]) }}" onclick="event.preventDefault();
                          document.getElementById('join-community-form-{{ $loop->iteration }}').submit();">Rejoindre</a>
                        <form id="join-community-form-{{ $loop->iteration }}" action="{{ route('front.communities.join', ['community' => $community]) }}" method="POST" class="hidden">
                          @csrf
                        </form>
                        
                        
                        
                      @endif
                    @endauth
                  </div>
                </div>
                <div class="mb-3">
                  <p class="leading-snug">{{ $community->description }}</p>
                </div>
                <p>{{ $community->users->count() }} membres - Créée le {{ $community->created_at->format('d/m/y') }}</p>
              </div>
            @endforeach
          </div>
          
          
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            right
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  
  
  
  
  <script>
    function leave(x) {
      x.innerHTML = "Quitter";
      x.classList.remove("btn-green");
      x.classList.add("btn-red");
    }
    function member(x) {
      x.innerHTML = "Membre";
      x.classList.remove("btn-red");
      x.classList.add("btn-green");
    }
  </script>
  
  

  
  
@endsection
