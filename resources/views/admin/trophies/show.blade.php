@extends('layouts.admin')

@section('title', 'Details for trophy id '.$trophy->id)

@section('content')
  <h1>Details for trophy id {{ $trophy->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('trophies.edit', ['trophy' => $trophy]) }}">Edit</a>
    <a class="nav-link" href="{{ route('trophies.destroy', ['trophy' => $trophy]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('trophies.destroy', ['trophy' => $trophy]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $trophy->id }}</td>
      </tr>
      <tr>
        <th scope="row">name</th>
        <td>{{ $trophy->name }}</td>
      </tr>
      
      
      @if ($trophy->image)
        <tr>
          <th scope="row">image</th>
          <td><img src="{{ asset('storage/'.$trophy->image) }}" class="img-thumbnail"></td>
        </tr>
      @endif
      
      
      
    </tbody>
  </table>
@endsection