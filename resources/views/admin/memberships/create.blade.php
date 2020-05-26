@extends('layouts.admin')

@section('title', 'Add new membership')

@section('content')
  <h1>Add new membership</h1>
  <form action="{{ route('admin.memberships.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
      <label for="user_id">user</label>
      <select class="custom-select" name="user_id">
        <option>select user</option>
        @foreach ($users as $user)
          <option value="{{ $user->id }}" {{ old('user_id') ? 'selected' : '' }}>u/{{ $user->display_name }}</option>
        @endforeach
      </select>
      @error('user_id')
        <small class="form-text text-muted">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group">
      <label for="community_id">community</label>
      <select class="custom-select" name="community_id">
        <option>select user</option>
        @foreach ($communities as $community)
          <option value="{{ $community->id }}" {{ old('community_id') == $user->id ? 'selected' : '' }}>k/{{ $community->display_name }}</option>
        @endforeach
      </select>
      @error('community_id')
        <small class="form-text text-muted">{{ $message }}</small>
      @enderror
    </div>

    <p>admin</p>
    <div class="form-group">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="admin" id="admin_false" value="0" {{ old('admin') == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="admin_false">false</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="admin" id="admin_true" value="1" {{ old('admin') == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="admin_true">true</label>
      </div>
    </div>

    <p>status</p>
    <div class="form-group">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_0" value="0" {{ old('status') == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_0">pending</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_1" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_1">approved</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_2" value="2" {{ old('status') == 2 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_2">rejected</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="status_3" value="3" {{ old('status') == 3 ? 'checked' : '' }}>
        <label class="form-check-label" for="status_3">postponed</label>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
