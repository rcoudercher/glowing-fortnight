@extends('layouts.settings')

@section('title', 'Communautés / Configuration')

@section('section-title', 'Communautés')

@section('section')
  
  
  
  <div class="md:flex">
    <div class="md:flex-auto">
      <h3 class="title h3">Communautés que vous administrez :</h3>
      <div>
      @if ($moderatorCommunities->count() != 0)
        <ul>
        @foreach ($moderatorCommunities as $moderatorCommunity)
        <li class="py-3 flex">
          <div>
            <a class="hover:underline" href="{{ route('front.communities.show', ['community' => $moderatorCommunity]) }}">r/{{ $moderatorCommunity->display_name }}</a>
          </div>
          <div>
            <a class="btn-xsm btn-black" href="{{ route('front.communities.admin', ['community' => $moderatorCommunity]) }}">administrer</a>
          </div>
        </li>
        @endforeach
        </ul>
        @else
        <p>aucune</p>
      @endif
      </div>
    </div>
    <div class="md:flex-auto">
      <h3 class="title h3">Autres communautés dont vous êtes membre :</h3>
      <div>
        @if ($nonModeratorCommunities->count() != 0)
          <ul>
            @foreach ($nonModeratorCommunities as $nonModeratorCommunity)
              <li class="py-3">
                <a class="hover:underline" href="{{ route('front.communities.show', ['community' => $nonModeratorCommunity]) }}">r/{{ $nonModeratorCommunity->display_name }}</a>
              </li>
            @endforeach
          </ul>
        @else
          <p>aucune</p>
        @endif
      </div>
    </div>
  </div>
  
  <div>
    <a class="btn btn-blue" href="{{ route('front.communities.create') }}">Créer une communauté</a>
  </div>
  

@endsection
