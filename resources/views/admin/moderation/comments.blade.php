@extends('layouts.admin')

@section('title', 'Comments moderation')

@section('content')
  <h1>Pending comments moderation</h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">show</th>
        <th scope="col">user</th>
        <th scope="col">post</th>
        <th scope="col">content</th>
        <th scope="col">status</th>
        <th scope="col">created_at</th>
        <th scope="col">approve</th>
        <th scope="col">reject</th>
        <th scope="col">postpone</th>
        
      </tr>
    </thead>
    <tbody>
    @foreach ($comments as $comment)
      <tr>
        <td><a href="{{ route('admin.comments.show', ['comment' => $comment]) }}">show</a></td>
        <td><a href="{{ route('admin.users.show', ['user' => $comment->user]) }}">u/{{ $comment->user->display_name }}</a></td>
        <td><a href="{{ route('admin.posts.show', ['post' => $comment->post]) }}">{{ $comment->post->title }}</a></td>
        <td>{{ $comment->content }}</td>
        <td>{{ $comment->status }}</td>
        <td>{{ $comment->created_at }}</td>
        <td><a href="{{ route('admin.comments.approve', ['comment' => $comment]) }}">approve</a></td>
        <td><a href="{{ route('admin.comments.reject', ['comment' => $comment]) }}">reject</a></td>
        <td><a href="{{ route('admin.comments.postpone', ['comment' => $comment]) }}">postpone</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>

@endsection
