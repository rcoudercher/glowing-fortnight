@extends('layouts.admin')

@section('title', 'Posts moderation')

@section('content')
  <h1>Pending posts moderation</h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">user</th>
        <th scope="col">community_id</th>
        <th scope="col">title</th>
        <th scope="col">type</th>
        <th scope="col">status</th>
        <th scope="col">created_at</th>
        <th scope="col">approve</th>
        <th scope="col">reject</th>
        <th scope="col">postpone</th>
        
      </tr>
    </thead>
    <tbody>
    @foreach ($posts as $post)
      <tr>
        <td><a href="{{ route('admin.users.show', ['user' => $post->user]) }}">u/{{ $post->user->display_name }}</a></td>
        <td><a href="{{ route('admin.communities.show', ['community' => $post->community]) }}">k/{{ $post->community->display_name }}</a></td>
        <td><a href="{{ route('admin.posts.update', ['post' => $post]) }}">{{ $post->title }}</a></td>
        <td>{{ $post->type }}</td>
        <td>{{ $post->status }}</td>
        <td>{{ $post->created_at }}</td>
        <td><a href="{{ route('admin.posts.approve', ['post' => $post]) }}">approve</a></td>
        <td><a href="{{ route('admin.posts.reject', ['post' => $post]) }}">reject</a></td>
        <td><a href="{{ route('admin.posts.postpone', ['post' => $post]) }}">postpone</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>

@endsection
