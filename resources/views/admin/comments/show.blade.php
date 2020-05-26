@extends('layouts.admin')

@section('title', 'Details for comment id '.$comment->id)

@section('content')
  <h1>Details for comment id {{ $comment->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('admin.comments.edit', ['comment' => $comment]) }}">Edit</a>
    <a class="nav-link" href="{{ route('admin.comments.destroy', ['comment' => $comment]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('admin.comments.destroy', ['comment' => $comment]) }}" method="POST" class="hidden">
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
        <th scope="row">user</th>
        <td><a href="{{ route('admin.users.show', ['user' => $comment->user]) }}">u/{{ $comment->user->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">post</th>
        <td><a href="{{ route('admin.posts.show', ['post' => $comment->post]) }}">{{ $comment->post->title }}</a></td>
      </tr>
      <tr>
        <th scope="row">parent</th>
        <td>
          @if ($comment->isChild())
            <a href="{{ route('admin.comments.show', ['comment' => $comment->parent()]) }}">{{ $comment->parent()->content }}</a>
          @else
            N/A
          @endif
        </td>
      </tr>
      <tr>
        <th scope="row">community</th>
        <td><a href="{{ route('admin.communities.show', ['community' => $comment->community]) }}">k/{{ $comment->community->display_name }}</a></td>
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