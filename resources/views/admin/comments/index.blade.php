@extends('layouts.admin')

@section('title', 'ADMIN Comments index')

@section('content')
  <h1>Comments index</h1>
  <p><a href="{{ route('comments.create') }}">Add new comment</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">show</th>
        <th scope="col">edit</th>
        <th scope="col">id</th>
        <th scope="col">user_id</th>
        <th scope="col">post_id</th>
        <th scope="col">community_id</th>
        <th scope="col">parent_id</th>
        <th scope="col">content</th>
        <th scope="col">created_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($comments as $comment)
      <tr>
        <td><a href="{{ route('comments.update', ['comment' => $comment]) }}">show</a></td>
        <td><a href="{{ route('comments.edit', ['comment' => $comment]) }}">edit</a></td>
        <th>{{ $comment->id }}</th>
        <td>{{ $comment->user_id }}</td>
        <td>{{ $comment->post_id }}</td>
        <td>{{ $comment->community_id }}</td>
        <td>{{ $comment->parent_id }}</td>
        <td>{{ $comment->content }}</td>
        <td>{{ $comment->created_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $comments->links() }}
  </div>
@endsection
