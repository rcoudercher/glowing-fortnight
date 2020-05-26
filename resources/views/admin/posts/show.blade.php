@extends('layouts.admin')

@section('title', 'Details for post id '.$post->id)

@section('content')
  <h1>Details for post id {{ $post->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('admin.posts.edit', ['post' => $post]) }}">Edit</a>
    <a class="nav-link" href="{{ route('admin.posts.destroy', ['post' => $post]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('admin.posts.destroy', ['post' => $post]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
    <a class="nav-link" href="{{ route('admin.posts.set-pending', ['post' => $post]) }}">Set pending</a>
    <a class="nav-link" href="{{ route('admin.posts.approve', ['post' => $post]) }}">Approve</a>
    <a class="nav-link" href="{{ route('admin.posts.reject', ['post' => $post]) }}">Reject</a>
    <a class="nav-link" href="{{ route('admin.posts.postpone', ['post' => $post]) }}">Postpone</a>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $post->id }}</td>
      </tr>
      <tr>
        <th scope="row">user</th>
        <td><a href="{{ route('admin.users.show', ['user' => $post->user ]) }}">u/{{ $post->user->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">community</th>
        <td><a href="{{ route('admin.communities.show', ['community' => $post->community]) }}">k/{{ $post->community->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">hash</th>
        <td>{{ $post->hash }}</td>
      </tr>
      <tr>
        <th scope="row">slug</th>
        <td>{{ $post->slug }}</td>
      </tr>
      <tr>
        <th scope="row">deleted</th>
        <td>{{ $post->deleted }}</td>
      </tr>
      <tr>
        <th scope="row">type</th>
        <td>{{ $post->type }}</td>
      </tr>
      <tr>
        <th scope="row">title</th>
        <td>{{ $post->title }}</td>
      </tr>
      <tr>
        <th scope="row">content</th>
        <td>{{ $post->content }}</td>
      </tr>
      <tr>
        <th scope="row">image</th>
        <td>{{ $post->image }}</td>
      </tr>
      <tr>
        <th scope="row">link</th>
        <td><a href="{{ $post->link }}">{{ $post->link }}</a></td>
      </tr>
      <tr>
        <th scope="row">status</th>
        <td>{{ $post->status }}</td>
      </tr>
      <tr>
        <th scope="row">moderated_at</th>
        <td>{{ $post->moderated_at }}</td>
      </tr>
      <tr>
        <th scope="row">moderated_by</th>
        <td>{{ $post->moderated_by }}</td>
      </tr>
      <tr>
        <th scope="row">creted_at</th>
        <td>{{ $post->created_at }}</td>
      </tr>
      <tr>
        <th scope="row">updated_by</th>
        <td>{{ $post->updated_at }}</td>
      </tr>
    </tbody>
  </table>
@endsection