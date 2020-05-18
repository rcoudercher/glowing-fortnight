@extends('layouts.admin')

@section('title', 'Details for message id '.$message->id)

@section('content')
  <h1>Details for message id {{ $message->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('admin.messages.edit', ['message' => $message]) }}">Edit</a>
    <a class="nav-link" href="{{ route('admin.messages.destroy', ['message' => $message]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Delete</a>
    <form id="destroy-form" action="{{ route('admin.messages.destroy', ['message' => $message]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $message->id }}</td>
      </tr>
      <tr>
        <th scope="row">hash</th>
        <td>{{ $message->hash }}</td>
      </tr>
      <tr>
        <th scope="row">from</th>
        <td><a href="{{ route('admin.users.show', ['user' => $message->sender]) }}">u/{{ $message->sender->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">to</th>
        <td><a href="{{ route('admin.users.show', ['user' => $message->receiver]) }}">u/{{ $message->receiver->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">ancestor</th>
        <td>@if ($message->isChild()) <a href="{{ route('admin.messages.show', ['message' => $message->ancestor()]) }}">ancestor</a> @else none @endif</td>
        <td>{{ $message->user_id }}</td>
      </tr>
      <tr>
        <th scope="row">title</th>
        <td>{{ $message->title }}</td>
      </tr>
      <tr>
        <th scope="row">content</th>
        <td>{{ $message->content }}</td>
      </tr>
      <tr>
        <th scope="row">read_at</th>
        <td>{{ $message->read_at }}</td>
      </tr>
      <tr>
        <th scope="row">archived_at</th>
        <td>{{ $message->archived_at }}</td>
      </tr>
      <tr>
        <th scope="row">created_at</th>
        <td>{{ $message->created_at }}</td>
      </tr>
      <tr>
        <th scope="row">updated_at</th>
        <td>{{ $message->updated_at }}</td>
      </tr>
      <tr>
        <th scope="row">deleted_at</th>
        <td>{{ $message->deleted_at }}</td>
      </tr>
    </tbody>
  </table>
@endsection