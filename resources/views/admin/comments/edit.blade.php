@extends('layouts.admin')

@section('title', 'Edit details for comment id '.$comment->id)

@section('content')
  <h1>Edit details for comment id {{ $comment->id }}</h1>
  <form action="{{ route('admin.comments.update', ['comment' => $comment]) }}" method="POST">
    @method('PATCH')
    @include('admin.comments.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection