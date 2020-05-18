@extends('layouts.admin')

@section('title', 'Edit details for user id '.$user->id)

@section('content')
  <h1>Edit details for user id {{ $user->id }}</h1>
  <form action="{{ route('admin.users.update', ['user' => $user]) }}" method="POST">
    @method('PATCH')
    @include('admin.users.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection