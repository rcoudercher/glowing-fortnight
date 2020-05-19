@extends('layouts.app')

@section('title', 'Publier sur k/'.$community->display_name)

@section('scripts')
  <script src="https://cdn.tiny.cloud/1/qkzidnm9epp85gb91fk89jbherl7rr6e8xna4bt3056xvvtx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'link lists paste',
      toolbar: 'bold italic strikethrough h2 | link blockquote | bullist numlist',
      // toolbar_location: 'bottom',
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
    
  function showPostForm() {
    document.getElementById("postForm").classList.remove("hidden");
    document.getElementById("imageForm").classList.add("hidden");
    document.getElementById("linkForm").classList.add("hidden");
    document.getElementById("postType").value = 1;
  }
  
  function showImageForm() {
    document.getElementById("imageForm").classList.remove("hidden");
    document.getElementById("postForm").classList.add("hidden");
    document.getElementById("linkForm").classList.add("hidden");
    document.getElementById("postType").value = 2;
  }
  
  function showLinkForm() {
    document.getElementById("linkForm").classList.remove("hidden");
    document.getElementById("postForm").classList.add("hidden");
    document.getElementById("imageForm").classList.add("hidden");
    document.getElementById("postType").value = 3;
  }
  </script>
  
@endsection

@section('content')
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          <div class="card">
            
            @if ($community->type == 3 && !Auth::user()->isMember($community))
              <p>Cette communauté est privée. Seuls les membres ont accès à son contenu.</p>
            @else
              
              <div class="mb-4">
                <h2 class="title h2">Publier sur r/{{ $community->display_name }}</h2>
              </div>
              
              <div class="mb-6">submission_text : {{ $community->submission_text }}</div>
              
              <div class="flex">
                <button onclick="showPostForm()" class="btn btn-blue flex-grow mr-2" type="button" name="button">Publication</button>
                <button onclick="showImageForm()" class="btn btn-blue flex-grow mr-2" type="button" name="button">Image</button>
                <button onclick="showLinkForm()" class="btn btn-blue flex-grow" type="button" name="button">Lien</button>
              </div>
              
              <div class="border-b-2 border-gray-900 my-6"></div>
              
              <div>
                <form action="{{ route('posts.create', ['community' => $community]) }}" method="post" enctype="multipart/form-data">
                  @csrf
                  
                  <input type="hidden" 
                  value="@if ($errors->has('image')) 2 @elseif ($errors->has('link')) 3 @else 1 @endif" 
                    name="type" id="postType">
                  
                  <div class="mb-6">
                    <input class="form-input w-full" type="text" name="title" value="{{ old('title') }}" placeholder="titre" autocomplete="off" required>
                    @error('title')
                      <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                    @enderror
                  </div>
                  
                  <div id="postForm" class="@if ($errors->has('image') || $errors->has('link')) hidden @endif">
                    <textarea name="content" id="content" rows="4" cols="80">{{ old('content') }}</textarea>
                    @error('content')
                      <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                    @enderror
                  </div>
                  
                  <div id="imageForm" class="@if (!$errors->has('image')) hidden @endif">
                    <input type="file" accept="image/*,.pdf" name="image">
                    @error('image')
                      <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                    @enderror
                  </div>
                  
                  <div id="linkForm" class="@if (!$errors->has('link')) hidden @endif">
                    <input class="form-input w-full" type="text" name="link" value="{{ old('link') }}" placeholder="url" autocomplete="off">
                    @error('link')
                      <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                    @enderror
                  </div>
                  
                  <button type="submit" class="btn btn-blue mt-6">Publier</button>
                </form>
              </div>
              
            @endif
          </div>
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="card">
            <div class="mb-4 title h3">r/{{ $community->display_name }}</div>
            <div>{{ $community->description }}</div>
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  @component('components.who')
  @endcomponent
@endsection
