@extends('layouts.app')

@section('title', $post->title)

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      
      toggleShareOptionsDropdown();
      copyPostLinkToClipboard();
      toggleReplyToCommentForms("replyBtn");
      
      // post vote buttons
      var postUp = document.getElementById("postUp");
      var postDown = document.getElementById("postDown");
      
      postUp.addEventListener('click', function(e) {
        var target = e.target || e.srcElement;
        vote(target, "post", "up");
        refreshVoteCounter(target, "post");
      });
      
      postDown.addEventListener("click", function(e) {
        var target = e.target || e.srcElement;
        vote(target, "post", "down");
        refreshVoteCounter(target, "post");
      });

      // comment vote buttons
      var commentUps = document.getElementsByClassName("commentUp");
      var commentDowns = document.getElementsByClassName("commentDown");
      
      for (var i = 0; i < commentUps.length; i++) {
        commentUps.item(i).addEventListener("click", function(e) {
          var target = e.target || e.srcElement;
          vote(target, "comment", "up");
          refreshVoteCounter(target, "comment");
        });
      }
      
      for (var i = 0; i < commentDowns.length; i++) {
        commentDowns.item(i).addEventListener("click", function(e) {
          var target = e.target || e.srcElement;
          vote(target, "comment", "down");
          refreshVoteCounter(target, "comment");
        });
      }
      
    });
  </script>
@endsection

@section('content')
  
<div class="bg-gray-300 min-h-screen">
  <div class="container mx-auto pt-8">
    <div class="lg:flex">
      <div id="left" class="lg:w-2/3">
        
        <div class="card">
          <div class="flex wrapper" data-hash="{{ $post->hash }}">
            <div class="">
              <div id="postUp" class="arrowUp voteBtn{{ $post->upVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-up"></i></div>
              <div class="p-1 text-center"><span class="counter">{{ $post->voteCount() }}</span></div>
              <div id="postDown" class="arrowDown voteBtn{{ $post->downVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-down"></i></div>
            </div>
            <div class="mx-5">
              <div class="mb-4 text-sm">
                <a class="hover:underline font-semibold" href="{{ route('communities.show', ['community' => $post->community]) }}">k/{{ $post->community->display_name }}</a>
                 - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('users.show.posts', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
              </div>
              <div class="mb-4">
                <h3 class="title h3">{{ $post->title }}</h3>
              </div>
              
              @switch($post->type)
                @case(1)
                  <div class="mb-4 text-base leading-snug">{!! $post->content !!}</div>
                @break
                @case(2)
                  <div class="mb-4 text-base leading-snug">
                    <img src="{{ $post->image }}">
                  </div>
                @break
                @case(3)
                  <div class="mb-4 text-base leading-snug">
                    <a class="text-blue-800 underline" href="{{ $post->link }}" rel="nofollow">{{ $post->link }}</a>
                  </div>
                @break
              @endswitch
              
              <div class="flex text-sm pb-8">
                <div>{{ $post->comments->count() }} commentaires</div>
                <div class="relative inline-block text-left cursor-pointer">
                  <div class="ml-4 hover:underline shareBtn">Partager</div>
                  <div class="wrapper origin-top-left absolute left-0 mt-2 w-40 rounded-md shadow-lg hidden z-50">
                    <div class="rounded-md bg-white shadow-xs">
                      <div class="py-1">
                        <span data-link="{{ route('posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}" class="copyLinkBtn block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">copier lien</a>
                      </div>
                    </div>
                  </div>
                </div>
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
            <form action="{{ route('comments.store', ['post' => $post]) }}" method="POST">
              @csrf
              <div class="mb-6">
                <textarea id="main" placeholder="Ajouter un commentaire public..." class="bg-gray-300 form-input w-full @error('content') border-red-500 @enderror" name="content" id="content" rows="4" cols="80">{{ old('content') }}</textarea>
              </div>
              @error('content')
                <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
              @enderror
              <button type="submit" class="btn btn-blue">Commenter</button>
            </form>
          @endauth
          
          <div class="mt-8">
            
            @foreach ($rootComments as $comment)
              <div class="mb-6">
                
                <div class="flex wrapper" data-hash="{{ $comment->hash }}" data-type="root" data-name="{{ $comment->user->display_name }}">
                  <div class="">
                    image
                  </div>
                  <div class="ml-4">
                    <div class="flex mb-2 text-sm">
                      <div class="">
                        <a class="font-bold" href="{{ route('users.show.posts', ['user' => $comment->user]) }}">u/{{ $comment->user->display_name }}</a>
                      </div>
                      <div class="ml-2">il y a {{ now()->diffInHours($comment->created_at) }} heures</div>
                    </div>
                    <div class="mb-3">
                      <p class="whitespace-pre-wrap text-base leading-snug">{{ $comment->content }}</p>
                    </div>
                    <div class="flex items-center">
                      <div class="voteBtn arrowUp commentUp {{ $comment->upVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-up"></i></div>
                      <div class="ml-2"><span class="counter" id="counter-{{ $comment->hash }}">{{ $comment->voteCount() }}</span></div>
                      <div class="ml-2 voteBtn arrowDown commentDown {{ $comment->downVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-down"></i></div>
                      <div class="ml-4 uppercase text-sm px-2 py-1 hover:bg-gray-200 rounded cursor-pointer replyBtn">répondre</div>
                    </div>              
                  </div>
                </div>
                
                @if ($comment->hasChildren())
                  @foreach ($comment->children() as $comment)
                    <div class="flex wrapper ml-12 mt-4" data-hash="{{ $comment->hash }}" data-type="child" data-name="{{ $comment->user->display_name }}">
                      <div class="">
                        image
                      </div>
                      <div class="ml-4 flex-grow">
                        <div class="flex mb-2 text-sm">
                          <div class="">
                            <a class="font-bold" href="{{ route('users.show.posts', ['user' => $comment->user]) }}">u/{{ $comment->user->display_name }}</a>
                          </div>
                          <div class="ml-2">il y a {{ now()->diffInHours($comment->created_at) }} heures</div>
                        </div>
                        <div class="mb-3">
                          <p class="whitespace-pre-wrap text-base leading-snug">{{ $comment->content }}</p>
                        </div>
                        <div class="flex items-center">
                          <div class="voteBtn arrowUp commentUp {{ $comment->upVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-up"></i></div>
                          <div class="ml-2"><span class="counter" id="counter-{{ $comment->hash }}">{{ $comment->voteCount() }}</span></div>
                          <div class="ml-2 voteBtn arrowDown commentDown {{ $comment->downVotes()->contains('user', Auth::user()) ? 'active' : '' }}"><i class="fas fa-arrow-down"></i></div>
                          <div class="ml-4 uppercase text-sm px-2 py-1 hover:bg-gray-200 rounded cursor-pointer replyBtn">répondre</div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
                
              </div>
            @endforeach
            
          </div>
        </div>
      </div>
      <div id="right" class="lg:ml-6 lg:w-1/3">
        <div class="card">
          <div>
            <div class="mb-4">k/{{ $community->display_name }}</div>
            <div id="description">{{ $community->description }}</div>
          </div>
        </div>
        @include('components.footer')
      </div>
    </div>
  </div>
</div>

@endsection
