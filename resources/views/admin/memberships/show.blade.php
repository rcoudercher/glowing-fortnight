@extends('layouts.admin')

@section('title', 'Details for membership id '.$membership->id)

@section('content')
  <h1>Details for membership id {{ $membership->id }}</h1>
  
  <nav class="nav pb-3">
    <a class="nav-link" href="{{ route('admin.memberships.edit', ['id' => $membership->id]) }}">Edit</a>
    <a class="nav-link" href="{{ route('admin.memberships.destroy', ['id' => $membership->id]) }}" onclick="event.preventDefault(); 
      document.getElementById('destroy-form').submit();">Detach</a>
    <form id="destroy-form" action="{{ route('admin.memberships.destroy', ['id' => $membership->id]) }}" method="POST" class="hidden">
      @method('DELETE')
      @csrf
    </form>
  </nav>
  
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">id</th>
        <td>{{ $membership->id }}</td>
      </tr>
      <tr>
        <th scope="row">user</th>
        <td><a href="{{ route('admin.users.show', ['user' => App\User::find($membership->user_id)]) }}">u/{{ App\User::find($membership->user_id)->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">community</th>
        <td><a href="{{ route('admin.communities.show', ['community' => App\Community::find($membership->community_id)]) }}">u/{{ App\Community::find($membership->community_id)->display_name }}</a></td>
      </tr>
      <tr>
        <th scope="row">admin</th>
        <td>{{ $membership->admin }}</td>
      </tr>
      <tr>
        <th scope="row">status</th>
        <td>{{ $membership->status }}</td>
      </tr>
      <tr>
        <th scope="row">moderated_at</th>
        <td>{{ $membership->moderated_at }}</td>
      </tr>
      <tr>
        <th scope="row">moderated_by</th>
        <td>
          @if (is_null($membership->moderated_by))
            N/A
          @else
            <a href="{{ route('admin.users.show', ['user' => App\User::find($membership->moderated_by)]) }}">u/{{ App\User::find($membership->moderated_by)->display_name }}</a>
          @endif
        </td>
      </tr>
      <tr>
        <th scope="row">created_at</th>
        <td>{{ $membership->created_at }}</td>
      </tr>
      <tr>
        <th scope="row">updated_at</th>
        <td>{{ $membership->updated_at }}</td>
      </tr>
    </tbody>
  </table>
@endsection