@extends('layouts.admin')

@section('title', 'Details for community id '.$community->id)

@section('content')
  <h1>Details for community id {{ $community->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('communities.edit', ['community' => $community]) }}">Edit</a>
    <a class="nav-link" href="{{ route('communities.destroy', ['community' => $community]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('communities.destroy', ['community' => $community]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $community->id }}</td>
      </tr>
      <tr>
        <th scope="row">creator</th>
        <td><a href="{{ route('users.show', ['user' => $community->creator]) }}">u/{{ $community->creator->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">type</th>
        <td>{{ $community->type }}</td>
      </tr>
      <tr>
        <th scope="row">hash</th>
        <td>{{ $community->hash }}</td>
      </tr>
      <tr>
        <th scope="row">name</th>
        <td>{{ $community->name }}</td>
      </tr>
      <tr>
        <th scope="row">display_name</th>
        <td>{{ $community->display_name }}</td>
      </tr>
      <tr>
        <th scope="row">title</th>
        <td>{{ $community->title }}</td>
      </tr>
      <tr>
        <th scope="row">description</th>
        <td>{{ $community->description }}</td>
      </tr>
      <tr>
        <th scope="row">submission_text</th>
        <td>{{ $community->submission_text }}</td>
      </tr>
      <tr>
        <th scope="row">created_at</th>
        <td>{{ $community->created_at }}</td>
      </tr>
      <tr>
        <th scope="row">updated_at</th>
        <td>{{ $community->updated_at }}</td>
      </tr>
    </tbody>
  </table>
@endsection
