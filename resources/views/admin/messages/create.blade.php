@extends('layouts.admin')

@section('title', 'ADMIN Add new message')

@section('content')
  <h1>Add new message</h1>
  <form action="{{ route('admin.messages.store') }}" method="POST">
    @csrf
    @include('admin.messages.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
