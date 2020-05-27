@extends('layouts.app')

@section('title', 'Configuration de k/'.$community->display_name)

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      
      // accept/reject moderation buttons click listeners
      var modBtns = document.getElementsByClassName("modBtn");
      for (var i = 0; i < modBtns.length; i++) {
        modBtns.item(i).addEventListener("click", function(e) {
          e.preventDefault();
          var target = e.target || e.srcElement;
          var form = target.nextElementSibling;
          form.submit();
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
            <h1 class="title h1 mb-6">Modération : demandes en attente</h1>
            <div class="mb-6">
              <h3 class="title h3 mb-3">Membres</h3>
              @if ($users->count() == 0)
                <p>Aucun nouveau membre en attente de modération.</p>
              @else
                <table class="table-auto w-full">
                  <thead>
                    <tr>
                      <th class="border px-4 py-2">Nom d'utilisateur</th>
                      <th class="border px-4 py-2">Accepter</th>
                      <th class="border px-4 py-2">Refuser</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <td class="border px-4 py-2"><a class="link" href="{{ route('users.show.posts', ['user' => $user]) }}">u/{{ $user->display_name }}</a></td>
                        <td class="border px-4 py-2 text-center">
                          <span class="link cursor-pointer modBtn">accepter</span>
                          <form action="{{ route('users.approve', ['community' => $community, 'user' => $user]) }}" method="POST" class="hidden">
                            @csrf
                          </form>
                        </td>
                        <td class="border px-4 py-2 text-center">
                          <span class="link cursor-pointer modBtn">refuser</span>
                          <form action="{{ route('users.reject', ['community' => $community, 'user' => $user]) }}" method="POST" class="hidden">
                            @csrf
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tobody>
                </table>
              @endif
            </div>
            <div class="mb-6">
              <h3 class="title h3 mb-3">Publications</h3>
              @if ($posts->count() == 0)
                <p>Aucune nouvelle publication en attente de modération.</p>
              @else
                <table class="table-auto w-full">
                  <thead>
                    <tr>
                      <th class="border px-4 py-2">Titre</th>
                      <th class="border px-4 py-2">Accepter</th>
                      <th class="border px-4 py-2">Refuser</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($posts as $post)
                      <tr>
                        <td class="border px-4 py-2"><a class="link" href="{{ route('posts.show', ['community' => $post->community, 'post' => $post, 'slug' => $post->slug]) }}">{{ $post->title }}</a></td>
                        <td class="border px-4 py-2 text-center">
                          <span class="link cursor-pointer modBtn">accepter</span>
                          <form action="{{ route('posts.approve', ['post' => $post]) }}" method="POST" class="hidden">
                            @csrf
                          </form>
                        </td>
                        <td class="border px-4 py-2 text-center">
                          <span class="link cursor-pointer modBtn">refuser</span>
                          <form action="{{ route('posts.reject', ['post' => $post]) }}" method="POST" class="hidden">
                            @csrf
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tobody>
                </table>
              @endif
            </div>
            <div class="mb-6">
              <h3 class="title h3 mb-3">Commentaires</h3>
              @if ($comments->count() == 0)
                <p>Aucun nouveau commentaire en attente de modération.</p>
              @else
                <table class="table-auto w-full">
                  <thead>
                    <tr>
                      <th class="border px-4 py-2">De</th>
                      <th class="border px-4 py-2">Contenu</th>
                      <th class="border px-4 py-2">Accepter</th>
                      <th class="border px-4 py-2">Refuser</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($comments as $comment)
                      <tr>
                        <td class="border px-4 py-2"><a class="link" href="{{ route('users.show.posts', ['user' => $comment->user]) }}">u/{{ $comment->user->display_name }}</a></td>
                        <td class="border px-4 py-2">{{ $comment->content }}</td>
                        <td class="border px-4 py-2 text-center">
                          <span class="link cursor-pointer modBtn">accepter</span>
                          <form action="{{ route('comments.approve', ['comment' => $comment]) }}" method="POST" class="hidden">
                            @csrf
                          </form>
                        </td>
                        <td class="border px-4 py-2 text-center">
                          <span class="link cursor-pointer modBtn">refuser</span>
                          <form action="{{ route('comments.reject', ['comment' => $comment]) }}" method="POST" class="hidden">
                            @csrf
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tobody>
                </table>
              @endif
            </div>
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
