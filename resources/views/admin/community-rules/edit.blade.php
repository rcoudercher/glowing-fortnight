@extends('layouts.admin')

@section('title', 'Edit details for community rule id '.$communityRule->id)

@section('content')
  <h1>Edit details for community rule id {{ $communityRule->id }}</h1>
  <form action="{{ route('admin.community-rules.update', ['community_rule' => $communityRule]) }}" method="POST">
    @method('PATCH')
    @include('admin.community-rules.form')
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection