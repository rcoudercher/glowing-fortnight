@extends('layouts.admin')

@section('title', 'ADMIN Add new post')

@section('content')
  <h1>Add new post</h1>
  <form action="{{ route('admin.posts.store') }}" method="POST">
    @csrf
    @include('admin.posts.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
