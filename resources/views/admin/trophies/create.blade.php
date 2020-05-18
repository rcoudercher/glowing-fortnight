@extends('layouts.admin')

@section('title', 'ADMIN Add new trophy')

@section('content')
  <h1>Add new trophy</h1>
  <form action="{{ route('admin.trophies.store') }}" method="POST" enctype="multipart/form-data">
    @include('admin.trophies.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
