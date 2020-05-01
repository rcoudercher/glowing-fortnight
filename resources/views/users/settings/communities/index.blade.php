@extends('layouts.user-settings')

@section('title', 'Communautés / Configuration')

@section('section-title', 'Communautés')

@section('section')
  
  @if ($communities->count() != 0)
    <p>Voici les communautés dont vous êtes membres :</p>
    <ul>
      @foreach ($communities as $community)
        <li class="py-3"><a class="hover:underline" href="{{ route('front.communities.show', ['community' => $community]) }}">r/{{ $community->display_name }}</a></li>
      @endforeach
    </ul>
  @else
    <p>Vous n'êtes membre d'aucune communauté.</p>
  @endif
  
  <div>
    <a class="btn btn-blue" href="{{ route('front.users.settings.communities.create') }}">Créer une communauté</a>
  </div>
  

@endsection
