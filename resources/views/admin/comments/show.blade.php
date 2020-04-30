@extends('layouts.admin')

@section('title', 'Details for comment id '.$comment->id)

@section('content')
  <h1>Details for comment id {{ $comment->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('comments.edit', ['comment' => $comment]) }}">Edit</a>
    <a class="nav-link" href="{{ route('comments.destroy', ['comment' => $comment]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('comments.destroy', ['comment' => $comment]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $comment->id }}</td>
      </tr>
      <tr>
        <th scope="row">user_id</th>
        <td>{{ $comment->user_id }}</td>
      </tr>
      <tr>
        <th scope="row">post_id</th>
        <td>{{ $comment->post_id }}</td>
      </tr>
      <tr>
        <th scope="row">parent_id</th>
        <td>{{ $comment->parent_id }}</td>
      </tr>
      <tr>
        <th scope="row">community_id</th>
        <td>{{ $comment->community_id }}</td>
      </tr>
      <tr>
        <th scope="row">hash</th>
        <td>{{ $comment->hash }}</td>
      </tr>
      <tr>
        <th scope="row">content</th>
        <td>{{ $comment->content }}</td>
      </tr>
    </tbody>
  </table>
@endsection