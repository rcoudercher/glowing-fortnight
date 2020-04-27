@extends('layouts.admin')

@section('title', 'ADMIN Add new comment')

@section('content')
  <h1>Add new comment</h1>
  <form action="{{ route('comments.store') }}" method="POST">
    @include('admin.comments.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
