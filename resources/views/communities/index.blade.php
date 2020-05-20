@extends('layouts.app')

@section('content')
  
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          
          
          <div class="card">
            @foreach ($communities as $community)
              <div class="py-5 border-b-2 border-gray-500">
                <div class="flex mb-3">
                  <h3 class="title h3 hover:underline flex-grow">
                    <a href="{{ route('communities.show', ['community' => $community]) }}">r/{{ $community->name }}: {{ substr($community->title, 0, 40) }}</a>
                  </h3>
                  <div>
                    @guest                      
                      <a class="btn-xsm btn-black" href="{{ route('communities.join', ['community' => $community]) }}" onclick="event.preventDefault(); 
                        document.getElementById('join-community-form-{{ $loop->iteration }}').submit();">Rejoindre</a>
                      <form id="join-community-form-{{ $loop->iteration }}" action="{{ route('communities.join', ['community' => $community]) }}" method="POST" class="hidden">
                        @csrf
                      </form>
                    @endguest
                    @auth
                      @if ($community->users->contains(Auth::user()))
                        <a class="btn-xsm btn-green" onmouseover="leave(this)" onmouseout="member(this)" href="{{ route('communities.leave', ['community' => $community]) }}" onclick="event.preventDefault();
                          document.getElementById('leave-community-form-{{ $loop->iteration }}').submit();">Membre</a>
                        <form id="leave-community-form-{{ $loop->iteration }}" action="{{ route('communities.leave', ['community' => $community]) }}" method="POST" class="hidden">
                          @csrf
                        </form>
                      @else
                        <a class="btn-xsm btn-black" href="{{ route('communities.join', ['community' => $community]) }}" onclick="event.preventDefault();
                          document.getElementById('join-community-form-{{ $loop->iteration }}').submit();">Rejoindre</a>
                        <form id="join-community-form-{{ $loop->iteration }}" action="{{ route('communities.join', ['community' => $community]) }}" method="POST" class="hidden">
                          @csrf
                        </form>
                        
                        
                        
                      @endif
                    @endauth
                  </div>
                </div>
                <div class="mb-3">
                  <p class="leading-snug">{{ $community->description }}</p>
                </div>
                <div class="flex">
                  <div class="">{{ $community->users->count() }} membres</div>
                  <div class="ml-3">Créée le {{ $community->created_at->format('d/m/y') }}</div>
                  <div class="ml-3">
                    @switch($community->type)
                      @case(1)
                        <span title="Tout le monde a accès au contenu de la communauté et tout le monde peut participer.">publique</span>
                        @break
                      @case(2)
                        <span title="Tout le monde a accès au contenu de la communauté mais seuls les membres peuvent participer.">restreinte</span>
                        @break
                      @case(3)
                        <span title="Seuls les membres ont accès au contenu de la communauté et peuvent y participer.">privée</span>
                        @break
                    @endswitch
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          
          
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
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
