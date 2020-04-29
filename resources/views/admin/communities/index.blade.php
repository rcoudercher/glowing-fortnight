@extends('layouts.admin')

@section('title', 'ADMIN Communities index')

@section('content')
  <h1>Communities index</h1>
  <p><a href="{{ route('communities.create') }}">Add new community</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">display_name</th>
        <th scope="col">title</th>
        <th scope="col">description</th>
        <th scope="col">created_at</th>
        <th scope="col">updated_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($communities as $community)
      <tr>
        <th scope="row">{{ $community->id }}</th>
        <td><a href="{{ route('communities.update', ['community' => $community]) }}">{{ $community->name }}</a></td>
        <td>{{ $community->display_name }}</td>
        <td>{{ $community->title }}</td>
        <td>{{ $community->description }}</td>
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
