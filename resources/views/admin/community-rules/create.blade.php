@extends('layouts.admin')

@section('title', 'ADMIN Add new community rule')

@section('content')
  <h1>Add new community</h1>
  <form action="{{ route('community-rules.store') }}" method="POST">
    @include('admin.community-rules.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
