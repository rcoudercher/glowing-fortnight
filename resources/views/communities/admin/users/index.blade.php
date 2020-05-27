@extends('layouts.app')

@section('title', 'Configuration de k/'.$community->display_name)

@section('scripts')
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function() {
      
      // accept/reject moderation buttons click listeners
      var excludeBtns = document.getElementsByClassName("excludeBtn");
      for (var i = 0; i < excludeBtns.length; i++) {
        excludeBtns.item(i).addEventListener("click", function(e) {
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
            <h1 class="title h1 mb-6">Users index</h1>
            
            <table class="table-auto w-full">
              <thead>
                <tr>
                  <th class="border px-4 py-2">Nom d'utilisateur</th>
                  <th class="border px-4 py-2">Admis le</th>
                  <th class="border px-4 py-2">Exclure</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($community->approvedUsers as $user)
                  <tr>
                    <td class="border px-4 py-2"><a class="link" href="{{ route('users.show.posts', ['user' => $user]) }}">u/{{ $user->display_name }}</a></td>
                    <td class="border px-4 py-2 text-center">{{ $user->membershipUpdatedAt($community) }}</td>
                    <td class="border px-4 py-2 text-center">
                      <span class="link cursor-pointer excludeBtn">exclure</span>
                      <form action="{{ route('communities.admin.users.exclude', ['community' => $community, 'user' => $user]) }}" method="POST" class="hidden">
                        @csrf
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tobody>
            </table>
            
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
