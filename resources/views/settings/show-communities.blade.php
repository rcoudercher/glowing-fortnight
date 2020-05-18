@extends('layouts.settings')

@section('title', 'Communautés / Configuration')

@section('section-title', 'Communautés')

@section('section')
  
  
  
  <div class="md:flex">
    <div class="md:flex-auto">
      <h3 class="title h3">Communautés que vous administrez :</h3>
      <div>
      @if ($adminCommunities->count() != 0)
        <ul>
        @foreach ($adminCommunities as $adminCommunity)
        <li class="py-3 flex">
          <div>
            <a class="hover:underline" href="{{ route('communities.show', ['community' => $adminCommunity]) }}">k/{{ $adminCommunity->display_name }}</a>
          </div>
          <div>
            <a class="btn-xsm btn-black" href="{{ route('communities.admin.dashboard', ['community' => $adminCommunity]) }}">administrer</a>
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
        @if ($nonAdminCommunities->count() != 0)
          <ul>
            @foreach ($nonAdminCommunities as $nonAdminCommunity)
              <li class="py-3">
                <a class="hover:underline" href="{{ route('communities.show', ['community' => $nonAdminCommunity]) }}">k/{{ $nonAdminCommunity->display_name }}</a>
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
    <a class="btn btn-blue" href="{{ route('communities.create') }}">Créer une communauté</a>
  </div>
  

@endsection
