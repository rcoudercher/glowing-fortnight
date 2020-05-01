@extends('layouts.app')

@section('title', 'Administration de r/'.$community->display_name)

@section('content')
  
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          <div class="border-solid border border-gray-400 bg-white shadow p-5 mb-5 rounded" style="font-family: 'Roboto', sans-serif;">
            
            <h1 class="title h1">Administration de r/{{ $community->display_name }}</h1>
            
            
            @if (!Auth::check())
              <div class="border-2 border-gray-600 rounded p-4 mt-8">
                <div class="flex">
                  <div class="flex-grow">
                    <p>Page réservée aux modérateurs de cette communauté :</p>
                  </div>
                  <div>
                    <a class="btn btn-black" href="{{ route('login') }}">Connexion</a>
                  </div>
                </div>
              </div>
            @elseif (!Auth::user()->isModerator($community))
              <p class="mt-8">Cette page est réservée aux modérateurs de cette communautés.</p>
              <div class="mt-4">
                <a class="btn btn-black" href="#">Contacter les modérateurs</a>
              </div>
            @else
              
              <h3 class="title h3 mt-8">Activité</h3>
              
              <div class="mt-4">
                <table class="table-auto w-full">
                  <tbody>
                    <tr>
                      <td class="border px-4 py-2">Nombre de commentaires</td>
                      <td class="border px-4 py-2">{{ $community->comments->count() }}</td>
                    </tr>
                    <tr>
                      <td class="border px-4 py-2">Dernier commentaire</td>
                      <td class="border px-4 py-2">{{ $lastComment->content ?? 'aucun commentaire'}}</td>
                    </tr>
                  </tobody>
                </table>
              </div>
              
              <h3 class="title h3 mt-8">Règles</h3>
              
              
              
              <h3 class="title h3 mt-8">Informations</h3>
              
              <div class="mt-4">
                <table class="table-auto w-full">
                  <tbody>
                    <tr>
                      <td class="border px-4 py-2">nom</td>
                      <td class="border px-4 py-2">{{ $community->display_name }}</td>
                    </tr>
                    <tr>
                      <td class="border px-4 py-2">date de création</td>
                      <td class="border px-4 py-2">{{ $community->created_at->format('d/m/y') }}</td>
                    </tr>
                    <tr>
                      <td class="border px-4 py-2">créateur</td>
                      <td class="border px-4 py-2">
                        <a class="hover:underline" href="{{ route('front.users.show', ['user' => $community->creator]) }}">u/{{ $community->creator->display_name }}</a>
                      </td>
                    </tr>
                    <tr>
                      <td class="border px-4 py-2">type</td>
                      <td class="border px-4 py-2">{{ $community->type }}</td>
                    </tr>
                    
                    <tr>
                      <td class="border px-4 py-2">title</td>
                      <td class="border px-4 py-2">{{ $community->title }}</td>
                    </tr>
                    <tr>
                      <td class="border px-4 py-2">description</td>
                      <td class="border px-4 py-2">{{ $community->description }}</td>
                    </tr>
                    <tr>
                      <td class="border px-4 py-2">message pour soumissions</td>
                      <td class="border px-4 py-2">{{ $community->submission_text }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mt-6">
                <a class="btn-sm btn-blue" href="{{ route('front.communities.edit', ['community' => $community]) }}">Modifier</a>
              </div>
            @endif
          </div>
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            <a class="hover:underline" href="{{ route('front.communities.show', ['community' => $community]) }}">r/{{ $community->display_name }}</a>
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  
  
@endsection
