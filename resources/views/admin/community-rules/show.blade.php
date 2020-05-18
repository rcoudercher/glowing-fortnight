@extends('layouts.admin')

@section('title', 'Details for community rule id '.$communityRule->id)

@section('content')
  <h1>Details for community rule id {{ $communityRule->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('admin.community-rules.edit', ['community_rule' => $communityRule]) }}">Edit</a>
    <a class="nav-link" href="{{ route('admin.community-rules.destroy', ['community_rule' => $communityRule]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('admin.community-rules.destroy', ['community_rule' => $communityRule]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $communityRule->id }}</td>
      </tr>
      <tr>
        <th scope="row">creator</th>
        <td><a href="{{ route('admin.users.show', ['user' => $communityRule->creator]) }}">u/{{ $communityRule->creator->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">community</th>
        <td><a href="{{ route('admin.communities.show', ['community' => $communityRule->community]) }}">k/{{ $communityRule->community->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">order</th>
        <td>{{ $communityRule->order }}</td>
      </tr>
      <tr>
        <th scope="row">title</th>
        <td>{{ $communityRule->title }}</td>
      </tr>
      <tr>
        <th scope="row">description</th>
        <td>{{ $communityRule->description }}</td>
      </tr>
    </tbody>
  </table>
@endsection
