@extends('layouts.app')

@section('content')
  
  <div class="bg-gray-300 min-h-screen">
    <div class="container mx-auto pt-8">
      <div class="lg:flex">
        <div id="left" class="lg:w-2/3">
          
          
          <div class="border-solid border border-gray-400 hover:border-gray-500 bg-white shadow p-5 mb-5 rounded" style="font-family: 'Roboto', sans-serif;">
            aaa
          </div>
          
          
        </div>
        <div id="right" class="lg:ml-6 lg:w-1/3">
          <div class="bg-white shadow p-4 mb-5 rounded">
            right
          </div>
          @include('components.footer')
        </div>
      </div>
    </div>
  </div>
  
  
@endsection
