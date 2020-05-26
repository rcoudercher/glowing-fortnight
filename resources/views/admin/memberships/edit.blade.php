@extends('layouts.admin')

@section('title', 'Edit details for membership id '.$membership->id)

@section('content')
  <h1>Edit details for membership id {{ $membership->id }}</h1>
  
  <p><a href="{{ route('admin.users.show', ['user' => App\User::find($membership->user_id)]) }}">
    u/{{ App\User::find($membership->user_id)->display_name }}</a> is a member of 
    <a href="{{ route('admin.communities.show', ['community' => App\Community::find($membership->community_id)]) }}">
      k/{{ App\Community::find($membership->community_id)->display_name }}</a>.</p>
  
  <form action="{{ route('admin.memberships.update', ['id' => $membership->id]) }}" method="POST">
    @csrf
    @method('PATCH')
    
    <input type="hidden" name="user_id" value="{{ $membership->user_id }}">
    <input type="hidden" name="community_id" value="{{ $membership->community_id }}">
    
    <p>admin</p>
    <div class="form-group">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="admin" id="admin_false" value="0" {{ old('admin') == 1 || $membership->status == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="admin_false">false</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="admin" id="admin_true" value="1" {{ old('admin') == 0 || $membership->status == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="admin_true">true</label>
      </div>
    </div>

    <p>status</p>
    <div class="form-group">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_0" value="0" {{ old('status') == 0 || $membership->status == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_0">pending</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_1" value="1" {{ old('status') == 1 || $membership->status == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_1">approved</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_2" value="2" {{ old('status') == 2 || $membership->status == 2 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_2">rejected</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_3" value="3" {{ old('status') == 3 || $membership->status == 3 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_3">postponed</label>
      </div>
    </div>



    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection