@extends('layouts.admin')

@section('title', 'Memberships moderation')

@section('content')
  <h1>Pending memberships moderation</h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">user</th>
        <th scope="col">community</th>
        <th scope="col">status</th>
        <th scope="col">created_at</th>
        <th scope="col">approve</th>
        <th scope="col">reject</th>
        <th scope="col">postpone</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($memberships as $membership)
      <tr>
        <td><a href="{{ route('admin.users.show', ['user' => App\User::find($membership->user_id)]) }}">u/{{ App\User::find($membership->user_id)->display_name }}</a></td>
        <td><a href="{{ route('admin.communities.show', ['community' => App\Community::find($membership->community_id)]) }}">k/{{ App\Community::find($membership->community_id)->display_name }}</a></td>
        <td>{{ $membership->status }}</td>
        <td>{{ $membership->created_at }}</td>
        <td><a href="{{ route('admin.memberships.approve', ['id' => $membership->id]) }}">approve</a></td>
        <td><a href="{{ route('admin.memberships.reject', ['id' => $membership->id]) }}">reject</a></td>
        <td><a href="{{ route('admin.memberships.postpone', ['id' => $membership->id]) }}">postpone</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>

@endsection
