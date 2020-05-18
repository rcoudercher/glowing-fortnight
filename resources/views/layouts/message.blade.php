@extends('layouts.app')

@section('content')
  
  <div class="md:flex">
    <div class="p-4 bg-white md:w-1/5 md:min-h-screen border-b border-gray-400 md:border-r">
      <div class="md:hidden">
        sandwich
      </div>
      <div class="hidden md:block">
        <div class="my-4">
          <a class="p-4 bg-red-600 hover:bg-red-500 text-white rounded" href="{{ route('messages.create') }}">Nouveau message</a>
        </div>
        <ul>
          <li class="p-2"><a class="messageNavLink" href="{{ route('messages.inbox') }}">Boîte de récetion</a></li>
          <li class="p-2"><a class="messageNavLink" href="{{ route('messages.unread') }}">Non lus</a></li>
          <li class="p-2"><a class="messageNavLink" href="{{ route('messages.sent') }}">Envoyés</a></li>
          <li class="p-2"><a class="messageNavLink" href="{{ route('messages.archived') }}">Archivés</a></li>
        </ul>
      </div>
    </div>
    <div class="bg-gray-200 md:w-4/5">
      @yield('section')
    </div>
  </div>
@endsection
