@extends('layouts.admin')

@section('title', 'ADMIN Add new community rule')

@section('content')
  <h1>Add new community rule</h1>
  <form action="{{ route('admin.community-rules.store') }}" method="POST">
    @csrf
    @include('admin.community-rules.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
