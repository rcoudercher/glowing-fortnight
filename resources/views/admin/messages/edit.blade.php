@extends('layouts.admin')

@section('title', 'Edit details for message id '.$message->id)

@section('content')
  <h1>Edit details for message id {{ $message->id }}</h1>
  <form action="{{ route('admin.messages.update', ['message' => $message]) }}" method="POST">
    @csrf
    @method('PATCH')
    @include('admin.messages.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection