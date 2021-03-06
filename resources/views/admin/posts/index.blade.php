@extends('layouts.admin')

@section('title', 'ADMIN Posts index')

@section('content')
  <h1>Posts index</h1>
  <p><a href="{{ route('admin.posts.create') }}">Add new post</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">user_id</th>
        <th scope="col">community_id</th>
        <th scope="col">hash</th>
        <th scope="col">title</th>
        <th scope="col">type</th>
        <th scope="col">status</th>
        <th scope="col">created_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($posts as $post)
      <tr>
        <th scope="row">{{ $post->id }}</th>
        <td>{{ $post->user_id }}</td>
        <td>{{ $post->community_id }}</td>
        <td>{{ $post->hash }}</td>
        <td><a href="{{ route('admin.posts.update', ['post' => $post]) }}">{{ $post->title }}</a></td>
        <td>{{ $post->type }}</td>
        <td>{{ $post->status }}</td>
        <td>{{ $post->created_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $posts->links() }}
  </div>
@endsection
