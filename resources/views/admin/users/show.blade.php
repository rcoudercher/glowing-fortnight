@extends('layouts.admin')

@section('title', 'Details for user id '.$user->id)

@section('content')
  <h1>Details for u/{{ $user->display_name }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('admin.users.edit', ['user' => $user]) }}">Edit</a>
    <a class="nav-link" href="{{ route('admin.users.destroy', ['user' => $user]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('admin.users.destroy', ['user' => $user]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $user->id }}</td>
      </tr>
      <tr>
        <th scope="row">name</th>
        <td>{{ $user->name }}</td>
      </tr>
      <tr>
        <th scope="row">display_name</th>
        <td>{{ $user->display_name }}</td>
      </tr>
      <tr>
        <th scope="row">email</th>
        <td>{{ $user->email }}</td>
      </tr>
      <tr>
        <th scope="row">description</th>
        <td>{{ $user->description }}</td>
      </tr>
      <tr>
        <th scope="row">created_at</th>
        <td>{{ $user->created_at }}</td>
      </tr>
      <tr>
        <th scope="row">updated_at</th>
        <td>{{ $user->updated_at }}</td>
      </tr>
      <tr>
        <th scope="row">trophies</th>
        <td>
          <ul>
            @foreach ($user->trophies as $trophy)
              <li>{{ $trophy->name }}</li>
            @endforeach
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
@endsection