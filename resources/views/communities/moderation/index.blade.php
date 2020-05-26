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
            <h1 class="title h1">Modération</h1>
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
