@extends('layouts.app')

@section('title', 'Administration de r/'.$community->display_name)

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      toggleCommunityRuleDescription();
    });
  </script>
@endsection

@section('content')
  
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          <div class="card">
            <h1 class="title h1">Administration de k/{{ $community->display_name }}</h1>
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
                      <td class="border px-4 py-2">{!! $lastComment->content ?? 'aucun commentaire' !!}</td>
                    </tr>
                  </tobody>
                </table>
              </div>
              
              <h3 class="title h3 my-6">Règles</h3>
              
              @if ($community->communityRules->count() == 0)
                <p>Cette communauté n'a encore aucun règle</p>
              @else

                <table class="table-auto w-full">
                  <tbody>
                    <tr class="bg-gray-200">
                      <td class="border px-4 py-2 text-center">ordre</td>
                      <td class="border px-4 py-2 text-center">mont.</td>
                      <td class="border px-4 py-2 text-center">desc.</td>
                      <td class="border px-4 py-2">titre</td>
                      <td class="border px-4 py-2 text-center">modifier</td>
                      <td class="border px-4 py-2 text-center">supprimer</td>
                    </tr>
                    
                    @foreach ($community->communityRules->sortBy('order') as $rule)
                      <tr>
                        <td class="border px-4 py-2 text-center">{{ $rule->order }}</td>
                        <td class="border px-4 py-2 text-center">
                          <a class="link" href="{{ route('community-rules.up', ['community' => $community, 'community_rule' => $rule]) }}">haut</a>
                        </td>
                        <td class="border px-4 py-2 text-center">
                          <a class="link" href="{{ route('community-rules.down', ['community' => $community, 'community_rule' => $rule]) }}">bas</a>
                        </td>
                        <td class="border px-4 py-2">{{ $rule->title }}</td>
                        <td class="border px-4 py-2 text-center"><a class="link" href="{{ route('community-rules.edit', ['community' => $community, 'community_rule' => $rule]) }}">modifier</a></td>
                        <td class="border px-4 py-2 text-center">                          
                          <a class="link" href="{{ route('community-rules.destroy', ['community' => $community, 'community_rule' => $rule]) }}" onclick="event.preventDefault(); 
                            document.getElementById('destroy-{{ $rule->hash }}').submit();">supprimer</a>
                          <form id="destroy-{{ $rule->hash }}" action="{{ route('community-rules.destroy', ['community' => $community, 'community_rule' => $rule]) }}" method="POST" class="hidden">
                            @method('DELETE')
                            @csrf
                          </form>
                        </td>
                      </tr>
                    @endforeach
                    
                  </tobody>
                </table>
                
              @endif
              
              @if ($community->communityRules->count() < 10)
                <p class="mt-6">
                  <a class="link" href="{{ route('community-rules.create', ['community' => $community]) }}">créer une nouvelle règle</a>
                </p>
              @else
                <p class="mt-6">Nombre maximum de règle autorisé : 10</p>
              @endif
              
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
                        <a class="hover:underline" href="{{ route('users.show.posts', ['user' => $community->creator]) }}">u/{{ $community->creator->display_name }}</a>
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
                <a class="btn-sm btn-blue" href="{{ route('communities.edit', ['community' => $community]) }}">Modifier</a>
              </div>
          </div>
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="card">
            <a class="hover:underline" href="{{ route('communities.show', ['community' => $community]) }}">k/{{ $community->display_name }}</a>
          </div>
          @include('components.community-rules')
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  
  
@endsection
