@extends('layouts.app')

@section('title', 'Configuration de k/'.$community->display_name)

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
    });
  </script>
@endsection

@section('content')
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          <div class="card">
            <h1 class="title h1 mb-6">Configuration de k/{{ $community->display_name }}</h1>
            
            <form class="" action="{{ route('communities.settings.update', ['community' => $community]) }}" method="POST">
              @csrf
              @method('PATCH')
              
              
              <div class="mb-6">
                <h4 class="title h4 mb-3">Type de communauté :</h4>
                <div class="mb-2">
                  <input type="radio" id="public" name="type" value="1" {{ $community->type == 1 ? 'checked' : '' }}>
                  <label class="ml-2 font-bold cursor-pointer" for="public">publique</label>
                </div>
                <p class="text-sm ml-6 mb-3">Tout le monde a accès au contenu de la communauté et tout le monde peut participer.</p>
                <div class="mb-2">
                  <input type="radio" id="restricted" name="type" value="2" {{ $community->type == 2 ? 'checked' : '' }}>
                  <label class="ml-2 font-bold cursor-pointer" for="restricted">restreinte</label>
                </div>
                <p class="text-sm ml-6 mb-3">Tout le monde a accès au contenu de la communauté mais seuls les membres peuvent participer.</p>
                <div class="mb-2">
                  <input type="radio" id="private" name="type" value="3" {{ $community->type == 3 ? 'checked' : '' }}>
                  <label class="ml-2 font-bold cursor-pointer" for="private">privée</label>
                </div>
                <p class="text-sm ml-6">Seuls les membres ont accès au contenu de la communauté et peuvent y participer.</p>
                @error('type')
                  <small class="form-text text-muted">{{ $message }}</small>
                @enderror
              </div>
              
              <div class="mb-6">
                <h4 class="title h4 mb-3">Modération :</h4>
                
                <div class="flex mb-2">
                  <span>Nouveaux membres :</span>
                  <input class="ml-2" type="radio" id="mod_members_yes" name="mod_members" value="1" {{ $community->mod_members == true ? 'checked' : '' }}>
                  <label class="ml-2" for="mod_members_yes">oui</label>
                  <input class="ml-2" type="radio" id="mod_members_no" name="mod_members" value="0" {{ $community->mod_members == false ? 'checked' : '' }}>
                  <label class="ml-2" for="mod_members_no">non</label>
                  @error('mod_members')
                    <small class="form-text text-muted">{{ $message }}</small>
                  @enderror
                </div>
                
                
                <div class="flex mb-2">
                  <span>Nouvelles publications :</span>
                  <input class="ml-2" type="radio" id="mod_posts_yes" name="mod_posts" value="1" {{ $community->mod_posts == true ? 'checked' : '' }}>
                  <label class="ml-2" for="mod_posts_yes">oui</label>
                  <input class="ml-2" type="radio" id="mod_posts_no" name="mod_posts" value="0" {{ $community->mod_posts == false ? 'checked' : '' }}>
                  <label class="ml-2" for="mod_posts_no">non</label>
                  @error('mod_posts')
                    <small class="form-text text-muted">{{ $message }}</small>
                  @enderror
                </div>
                
                <div class="flex">
                  <span>Nouveaux commentaires :</span>
                  <input class="ml-2" type="radio" id="mod_comments_yes" name="mod_comments" value="1" {{ $community->mod_comments == true ? 'checked' : '' }}>
                  <label class="ml-2" for="mod_comments_yes">oui</label>
                  <input class="ml-2" type="radio" id="mod_comments_no" name="mod_comments" value="0" {{ $community->mod_comments == false ? 'checked' : '' }}>
                  <label class="ml-2" for="mod_comments_no">non</label>
                  @error('mod_comments')
                    <small class="form-text text-muted">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              
              <button type="submit" class="btn btn-blue">Enregistrer</button>
            </form>
            

            
          </div>
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          @include('components.community-admin-nav')
          @include('components.community-rules')
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
@endsection
