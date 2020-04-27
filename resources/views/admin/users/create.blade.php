@extends('layouts.admin')

@section('title', 'ADMIN Add new user')

@section('content')
  <h1>Add new user</h1>
  <form method="POST" action="{{ route('users.store') }}">
    @include('admin.users.form')
    
    <hr>
    
    {{-- password --}}
    <div class="form-group">
      <label for="password">{{ __('Password') }}</label>
      <input type="password" id="password" class="form-control" name="password" required autocomplete="new-password">
      @error('password')
        <small class="form-text text-muted">{{ $message }}</small>
      @enderror
    </div>
    <div class="form-group">
      <label for="password_confirmation">{{ __('Confirm Password') }}</label>
      <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>
    {{-- end password --}}
    
    <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
  </form>
@endsection