@extends('layouts.app')

@section('content')






<div class="bg-gray-300 h-screen">
  <div class="container mx-auto">
    <div class="py-8">
      Hello world!
    </div>
  </div>
</div>



<div id="notif-container" class="absolute top-0 right-0 mr-5 mt-24 w-1/4">
  
  
  {{-- @for ($i=0; $i < 5; $i++)
    <div class="py-3 pl-6 pr-3 rounded-lg bg-gray-900 shadow-lg mb-4">
      <div class="flex items-center justify-between flex-wrap">
        <div class="w-full flex-1 flex items-center sm:w-0">
          <p class="text-gray-200">Get the HTML</p>
        </div>
        <div class="flex-shrink-0">
            <div class="rounded-md shadow-sm">
              <a href="/pricing" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">
                X
              </a>
            </div>
          </div>
      </div>
    </div>
  @endfor --}}
  
  
  @for ($i=0; $i < 5; $i++)
    <div class="py-3 pl-6 pr-3 rounded-lg bg-red-300 shadow-lg mb-4">
      <div class="flex items-center justify-between flex-wrap">
        <div class="w-full flex-1 flex items-center sm:w-0">
          <p class="text-red-900">Communauté bien créée.</p>
        </div>
        <div class="flex-shrink-0">
            <div class="rounded-md shadow-sm">
              <a href="/pricing" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">
                X
              </a>
            </div>
          </div>
      </div>
    </div>
  @endfor

  
</div>
















@endsection
