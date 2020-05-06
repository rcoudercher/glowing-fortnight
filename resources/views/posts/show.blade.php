@extends('layouts.app')

@section('title', 'eee')

@section('scripts')
  <script src="https://cdn.tiny.cloud/1/qkzidnm9epp85gb91fk89jbherl7rr6e8xna4bt3056xvvtx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'link lists paste',
      toolbar: 'bold italic strikethrough | link blockquote | bullist numlist',
      toolbar_location: 'bottom',
      menubar: false,
      branding: false,
      statusbar: false,
      link_title: false,
      target_list: false,
      link_assume_external_targets: 'http',
      // strip all tags from what is pasted
      paste_preprocess: function(plugin, args) {
        console.log(args.content);        
        args.content = args.content.replace(/(<([^>]+)>)/ig,"");
      }
    });
  </script>  
@endsection

@section('content')
  
<div class="bg-gray-300 min-h-screen">

  
  <div class="container mx-auto pt-8">
    <div class="lg:flex">
      <div id="left" class="lg:w-2/3">
        
        
        <div style="font-family: 'Roboto', sans-serif;" class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow px-5 py-5 mb-5 rounded">
          <div class="flex">
            <div>
              <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↑</div>
              <div class="p-1 text-center">7.9k</div>
              <div class="bg-gray-200 hover:bg-gray-300 p-1 text-center rounded-lg">↓</div>
            </div>
            <div class="mx-5">
              <div class="mb-4 text-sm">
                <a class="hover:underline font-semibold" href="{{ route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->display_name }}</a>
                 - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
              </div>
              <div class="mb-4">
                <h3 class="title h3">{{ $post->title }}</h3>
              </div>
              <div class="mb-4 text-base leading-snug">{{ $post->content }}</div>
              <div class="flex text-sm pb-8">
                <div>{{ $post->comments->count() }} commentaires</div>
                <div class="ml-4 hover:underline">Partager</div>
                <div class="ml-4 hover:underline">Sauvegarder</div>
              </div>
            </div>
          </div>
          
          
          
          @guest
            <div class="p-5 border border-gray-400 rounded">
              <div class="flex">
                <div class="flex-grow mt-3">Connectez-vous pour écrire un commentaire</div>
                <div>
                  <a class="btn-sm btn-black" href="{{ route('login') }}">Connexion</a>
                </div>
                <div class="ml-4">
                  <a class="btn-sm btn-black" href="{{ route('register') }}">Inscription</a>
                </div>
              </div>
            </div>
          @endguest
          
          @auth
            <form action="{{ route('front.comments.store', ['community' => $community, 'post' => $post, 'slug' => $post->slug]) }}" method="POST">
              @csrf
              <div class="mb-6">
                <textarea placeholder="Qu'en pensez-vous ?" class="bg-gray-300 form-input w-full @error('content') border-red-500 @enderror" name="content" id="content" rows="4" cols="80">{{ old('content') }}</textarea>
              </div>
              @error('content')
                <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
              @enderror
              <button type="submit" class="btn btn-blue">Commenter</button>
            </form>
          @endauth
          
          
          <div class="mt-8 text-base leading-snug">
            @foreach ($post->comments as $comment)
              <div class="mb-4">{!! $comment->content !!}</div>
            @endforeach
          </div>
          
        </div>
        
        

      </div>
      <div id="right" class="lg:ml-6 lg:w-1/3">
        <div class="bg-white shadow p-4 mb-5 rounded">
          <div>
            <div class="mb-4">r/{{ $community->display_name }}</div>
            <div>{{ $community->description }}</div>
          </div>
        </div>
        @include('components.footer')
      </div>
    </div>
  </div>
</div>
  
  
@endsection
