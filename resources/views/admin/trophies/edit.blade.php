@extends('layouts.admin')

@section('title', 'Edit details for trophy id '.$trophy->id)

@section('content')
  <h1>Edit details for trophy id {{ $trophy->id }}</h1>
  <form action="{{ route('trophies.update', ['trophy' => $trophy]) }}" method="POST">
    @method('PATCH')
    @include('admin.trophies.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection