@extends('layouts.admin')

@section('title', 'ADMIN Community rules index')

@section('content')
  <h1>Community rules index</h1>
  <p><a href="{{ route('admin.community-rules.create') }}">Add new community rule</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">show</th>
        <th scope="col">creator</th>
        <th scope="col">community</th>
        <th scope="col">title</th>
        <th scope="col">created_at</th>
        <th scope="col">updated_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($communityRules as $rule)
      <tr>
        <th scope="row">{{ $rule->id }}</th>
        <td><a href="{{ route('admin.community-rules.show', ['community_rule' => $rule]) }}">show</a></td>
        <td><a href="{{ route('admin.users.show', ['user' => $rule->creator]) }}">u/{{ $rule->creator->display_name }}</a></td>
        <td><a href="{{ route('admin.communities.show', ['community' => $rule->community]) }}">k/{{ $rule->community->display_name }}</a></td>
        <td>{{ $rule->title }}</td>
        <td>{{ $rule->created_at }}</td>
        <td>{{ $rule->updated_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $communityRules->links() }}
  </div>
@endsection
