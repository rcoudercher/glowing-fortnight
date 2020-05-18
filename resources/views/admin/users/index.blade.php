@extends('layouts.admin')

@section('title', 'ADMIN Users index')

@section('content')
  <h1>Users index</h1>
  <p><a href="{{ route('admin.users.create') }}">Add new user</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">created_at</th>
        <th scope="col">updated_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
      <tr>
        <th scope="row">{{ $user->id }}</th>
        <td><a href="{{ route('admin.users.update', ['user' => $user]) }}">{{ $user->name }}</a></td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->created_at }}</td>
        <td>{{ $user->updated_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $users->links() }}
  </div>
@endsection