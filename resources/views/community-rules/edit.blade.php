@extends('layouts.app')

@section('title', 'Modifier une règle pour k/'.$community->display_name)

@section('scripts')
  <script type="text/javascript">
    function titleCharcountUpdate(str) {
      var lng = str.length;
      document.getElementById("titleCharcount").innerHTML = "Longueur du titre : " + lng + ' / 50';
    }
    function descriptionCharcountUpdate(str) {
      var lng = str.length;
      document.getElementById("descriptionCharcount").innerHTML = "Longueur de la description : " + lng + ' / 400';
    }
  </script>
@endsection

@section('content')
    
    <div class="bg-gray-300 min-h-screen">
      <div class="container mx-auto pt-8">
        <div class="lg:flex">
          <div id="left" class="lg:w-2/3">
            <div class="card flex-col">
              <h1 class="title h2 mb-6">Modifier une nouvelle règle pour k/{{ $community->display_name }}</h1>
              <form class="" action="{{ route('community-rules.update', ['community_rule' => $communityRule, 'community' => $community]) }}" method="POST">
                @method('PATCH')
                @include('community-rules.form')
                <button type="submit" class="btn btn-blue">Enregistrer</button>
              </form>
            </div>
          </div>
          <div id="right" class="lg:ml-6 lg:w-1/3">
            @include('components.community-admin-nav')
            @include('components.footer')
          </div>
        </div>
      </div>
    </div>
    
    
    
    
@endsection
