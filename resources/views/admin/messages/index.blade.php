@extends('layouts.admin')

@section('title', 'ADMIN Messages index')

@section('content')
  <h1>Messages index</h1>
  <p><a href="{{ route('admin.messages.create') }}">Add new message</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">show</th>
        <th scope="col">id</th>
        <th scope="col">from</th>
        <th scope="col">to</th>
        <th scope="col">ancestor_id</th>
        <th scope="col">title</th>
        <th scope="col">created_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($messages as $message)
      <tr>
        <td><a href="{{ route('admin.messages.show', ['message' => $message]) }}">show</a></td>
        <td>{{ $message->id }}</td>
        <td><a href="{{ route('admin.users.show', ['user' => $message->sender]) }}">u/{{ $message->sender->display_name }}</a></td>
        <td><a href="{{ route('admin.users.show', ['user' => $message->receiver]) }}">u/{{ $message->receiver->display_name }}</a></td>
        <td>@if ($message->isChild()) <a href="{{ route('admin.messages.show', ['message' => $message->ancestor()]) }}">ancestor</a> @endif</td>
        <td>{{ $message->title }}</td>
        <td>{{ $message->created_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $messages->links() }}
  </div>
@endsection
