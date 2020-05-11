@extends('layouts.app')

@section('title', $post->title)

@section('scripts')
  <script src="https://cdn.tiny.cloud/1/qkzidnm9epp85gb91fk89jbherl7rr6e8xna4bt3056xvvtx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#main',
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
          <div class="flex" data-hash="{{ $post->hash }}">
            <div class="voteWrapper">
              <div id="postUp" class="voteBtn{{ $post->upVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-up"></i></div>
              <div class="p-1 text-center">{{ $post->voteCount() }}</div>
              <div id="postDown" class="voteBtn{{ $post->downVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-down"></i></div>
            </div>
            <div class="mx-5">
              <div class="mb-4 text-sm">
                <a class="hover:underline font-semibold" href="{{ route('front.communities.show', ['community' => $post->community]) }}">r/{{ $post->community->display_name }}</a>
                 - Publié par <a class="hover:underline" href="{{ $post->user->deleted ? '#' : route('front.users.show.posts', ['user' => $post->user]) }}">u/{{ $post->user->deleted ? '[supprimé]' : $post->user->display_name }}</a>, il y a {{ now()->diffInHours($post->created_at) }} heures
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
                <textarea id="main" placeholder="Qu'en pensez-vous ?" class="bg-gray-300 form-input w-full @error('content') border-red-500 @enderror" name="content" id="content" rows="4" cols="80">{{ old('content') }}</textarea>
              </div>
              @error('content')
                <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
              @enderror
              <button type="submit" class="btn btn-blue">Commenter</button>
            </form>
          @endauth
          
          
          <div class="mt-8 text-base leading-snug">
            @foreach ($rootComments as $comment)
              <div class="mb-6">
                <div class="flex mb-6" data-hash="{{ $comment->hash }}">
                  <div class="voteWrapper">
                    <div class="commentUp voteBtn{{ $comment->upVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-up"></i></div>
                    <div class="commentDown voteBtn{{ $comment->downVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-down"></i></div>
                  </div>
                  <div class="ml-6 w-full">
                    <div class="text-sm mb-2 flex">
                      <div class="">
                        <a  class="hover:underline" href="{{ route('front.users.show.posts', ['user' => $comment->user]) }}">u/{{ $comment->user->display_name }}</a>
                      </div>
                      <div class="ml-2"><span id="counter-{{ $comment->hash }}">{{ $comment->voteCount() }}</span> votes</div>
                      <div class="ml-2">il y a {{ now()->diffInHours($comment->created_at) }} heures</div>
                    </div>
                    <div class="mb-2">
                      {!! $comment->content !!}
                    </div>
                    <div class="flex text-sm">
                      <div class="px-2 py-1 hover:bg-gray-200 rounded cursor-pointer replyBtn" data-hash="{{ $comment->getEncryptedHash() }}">répondre</div>
                      <div class="px-2 py-1 hover:bg-gray-200 rounded cursor-pointer ml-2"><span>partager</span></div>
                      <div class="px-2 py-1 hover:bg-gray-200 rounded cursor-pointer ml-2"><a href="">signaler</a></div>
                    </div>
                    <div class="mt-2 text-sm">
                      Wilson score : {{ $comment->wilsonScore() }}
                    </div>
                  </div>
                </div>
                
                @if ($comment->children()->count() != 0)
                  @foreach ($comment->children() as $comment)
                    <div class="mb-6 ml-6">
                      <div class="flex" data-hash="{{ $comment->hash }}">
                        <div class="voteWrapper">
                          <div class="commentUp voteBtn{{ $comment->upVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-up"></i></div>
                          <div class="commentDown voteBtn{{ $comment->downVotes()->contains('user', Auth::user()) ? ' active' : '' }}"><i class="fas fa-arrow-down"></i></div>
                        </div>
                        <div class="ml-6 w-full">
                          <div class="text-sm mb-2 flex">
                            <div class="">
                              <a  class="hover:underline" href="{{ route('front.users.show.posts', ['user' => $comment->user]) }}">u/{{ $comment->user->display_name }}</a>
                            </div>
                            <div class="ml-2"><span id="counter-{{ $comment->hash }}">{{ $comment->voteCount() }}</span> votes</div>
                            <div class="ml-2">il y a {{ now()->diffInHours($comment->created_at) }} heures</div>
                          </div>
                          <div class="mb-2">
                            {!! $comment->content !!}
                          </div>
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
        <div class="bg-white shadow p-4 mb-5 rounded">
          <div>
            <div class="mb-4">r/{{ $community->display_name }}</div>
            <div id="description">{{ $community->description }}</div>
          </div>
        </div>
        @include('components.footer')
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
var replyBtns = document.querySelectorAll('.replyBtn');
var csrf = document.getElementsByName('csrf-token').item(0).getAttribute("content");

for (const el of replyBtns) {
  
  el.addEventListener('click', function() {
    
    if (el.hasAttribute("data-reply")) {
      
      el.removeAttribute("data-reply");
      el.parentNode.classList.toggle('mb-4');
      el.classList.toggle('bg-gray-300')
      
      var parent = el.parentNode.parentNode;
      parent.removeChild(parent.lastChild);
      
    } else {
      
      el.setAttribute("data-reply", "");
      
      // create a form
        var f = document.createElement("form");
        f.setAttribute('method',"post");
        f.setAttribute('action',"{{ route('front.comments.store', ['community' => $community, 'post' => $post, 'slug' => $post->slug]) }}");

        var t = document.createElement("input");
        t.setAttribute('type',"hidden");
        t.setAttribute('name',"_token");
        t.setAttribute('value', csrf);
        
        var h = document.createElement("input");
        h.setAttribute('type',"hidden");
        h.setAttribute('name',"parent_id");
        h.setAttribute('value', el.getAttribute('data-hash'));
        
        var i = document.createElement("textarea");
        i.classList.add('reply');
        i.setAttribute('name',"content");
        
        var s = document.createElement("input");
        s.setAttribute('type',"submit");
        s.setAttribute('value',"répondre");
        s.classList.add('btn-sm', 'btn-blue', 'mt-2', 'cursor-pointer', 'w-24');

        f.appendChild(t);
        f.appendChild(h);
        f.appendChild(i);
        f.appendChild(s);
      // end create form
        
      el.parentNode.parentNode.appendChild(f);
      
      el.parentNode.classList.toggle('mb-4');
      el.classList.toggle('bg-gray-300')
      
      tinymce.init({
        selector: '.reply',
        plugins: 'link lists paste',
        toolbar: 'bold italic strikethrough | link',
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
    }
  });
}

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



</script>
  
  
@endsection
