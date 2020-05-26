@extends('layouts.admin')

@section('title', 'Memberships index')

@section('content')
  <h1>Memberships index</h1>
  <p><a href="{{ route('admin.memberships.create') }}">Add new membership</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">user</th>
        <th scope="col">community</th>
        <th scope="col">admin</th>
        <th scope="col">status</th>
        <th scope="col">created_at</th>
        <th scope="col">show</th>
        <th scope="col">edit</th>
        <th scope="col">detach</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($memberships as $membership)
      <tr>
        <td>{{ $membership->id }}</td>
        <td><a href="{{ route('admin.users.show', ['user' => App\User::find($membership->user_id)]) }}">u/{{ App\User::find($membership->user_id)->display_name }}</a></td>
        <td><a href="{{ route('admin.communities.show', ['community' => App\Community::find($membership->community_id)]) }}">k/{{ App\Community::find($membership->community_id)->display_name }}</a></td>
        <td>{{ $membership->admin }}</td>
        <td>{{ $membership->status }}</td>
        <td>{{ $membership->created_at }}</td>
        <td><a href="{{ route('admin.memberships.show', ['id' => $membership->id]) }}">show</a></td>
        <td><a href="{{ route('admin.memberships.edit', ['id' => $membership->id]) }}">Edit</a></td>
        <td>
          <a href="{{ route('admin.memberships.destroy', ['id' => $membership->id]) }}" onclick="event.preventDefault(); 
            document.getElementById('destroy-form-{{ $membership->id }}').submit();">Detach</a>
          <form id="destroy-form-{{ $membership->id }}" action="{{ route('admin.memberships.destroy', ['id' => $membership->id]) }}" method="POST" class="hidden">
            @method('DELETE')
            @csrf
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $memberships->links() }}
  </div>
@endsection
