@extends('layouts.admin')

@section('title', 'Edit details for post id '.$post->id)

@section('content')
  <h1>Edit details for post id {{ $post->id }}</h1>
  <form action="{{ route('admin.posts.update', ['post' => $post]) }}" method="POST">
    @method('PATCH')
    @include('admin.posts.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection