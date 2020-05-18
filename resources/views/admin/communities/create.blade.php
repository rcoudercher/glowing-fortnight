@extends('layouts.admin')

@section('title', 'ADMIN Add new community')

@section('content')
  <h1>Add new community</h1>
  <form action="{{ route('admin.communities.store') }}" method="POST">
    @include('admin.communities.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
