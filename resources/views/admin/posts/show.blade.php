@extends('layouts.admin')

@section('title', 'Details for post id '.$post->id)

@section('content')
  <h1>Details for post id {{ $post->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('posts.edit', ['post' => $post]) }}">Edit</a>
    <a class="nav-link" href="{{ route('posts.destroy', ['post' => $post]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $post->id }}</td>
      </tr>
      <tr>
        <th scope="row">user_id</th>
        <td>{{ $post->user_id }}</td>
      </tr>
      <tr>
        <th scope="row">sub_id</th>
        <td>{{ $post->sub_id }}</td>
      </tr>
      <tr>
        <th scope="row">notification</th>
        <td>{{ $post->notification }}</td>
      </tr>
      <tr>
        <th scope="row">public</th>
        <td>{{ $post->public }}</td>
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
        <th scope="row">slug</th>
        <td>{{ $post->slug }}</td>
      </tr>
    </tbody>
  </table>
@endsection