@extends('layouts.admin')

@section('title', 'ADMIN Add new trophy')

@section('content')
  <h1>Add new trophy</h1>
  <form action="{{ route('trophies.store') }}" method="POST">
    @include('admin.trophies.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
