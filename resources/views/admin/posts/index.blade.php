@extends('layouts.admin')

@section('title', 'ADMIN Posts index')

@section('content')
  <h1>Posts index</h1>
  <p><a href="{{ route('posts.create') }}">Add new post</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">user_id</th>
        <th scope="col">community_id</th>
        <th scope="col">notification</th>
        <th scope="col">public</th>
        <th scope="col">title</th>
        <th scope="col">created_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($posts as $post)
      <tr>
        <th scope="row">{{ $post->id }}</th>
        <td>{{ $post->user_id }}</td>
        <td>{{ $post->community_id }}</td>
        <td>{{ $post->notification }}</td>
        <td>{{ $post->public }}</td>
        <td><a href="{{ route('posts.update', ['post' => $post]) }}">{{ $post->title }}</a></td>
        <td>{{ $post->created_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $posts->links() }}
  </div>
@endsection
