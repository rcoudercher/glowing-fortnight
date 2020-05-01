@extends('layouts.admin')

@section('title', 'ADMIN Communities index')

@section('content')
  <h1>Communities index</h1>
  <p><a href="{{ route('communities.create') }}">Add new community</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">creator</th>
        <th scope="col">type</th>
        <th scope="col">hash</th>
        <th scope="col">display_name</th>
        <th scope="col">created_at</th>
        <th scope="col">updated_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($communities as $community)
      <tr>
        <th scope="row">{{ $community->id }}</th>
        <td><a href="{{ route('users.show', ['user' => $community->creator]) }}">u/{{ $community->creator->display_name }}</a></td>
        <td>{{ $community->type }}</td>
        <td>{{ $community->hash }}</td>
        <td><a href="{{ route('communities.update', ['community' => $community]) }}">{{ $community->display_name }}</a></td>
        <td>{{ $community->created_at }}</td>
        <td>{{ $community->updated_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $communities->links() }}
  </div>
@endsection
