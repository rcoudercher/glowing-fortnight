@extends('layouts.admin')

@section('title', 'Edit details for community id '.$community->id)

@section('content')
  <h1>Edit details for community id {{ $community->id }}</h1>
  <form action="{{ route('admin.communities.update', ['community' => $community]) }}" method="POST">
    @csrf
    @method('PATCH')
    @include('admin.communities.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection