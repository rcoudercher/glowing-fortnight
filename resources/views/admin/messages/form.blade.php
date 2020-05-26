<div class="form-group">
  <label for="from_id">from</label>
  <select class="custom-select" name="from_id">
    <option>select user</option>
    @foreach ($users as $user)
      <option value="{{ $user->id }}" {{ old('from_id') == $user->id || $message->sender == $user ? 'selected' : '' }}>u/{{ $user->display_name }}</option>
    @endforeach
  </select>
  @error('from_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="to_id">to</label>
  <select class="custom-select" name="to_id">
    <option>select user</option>
    @foreach ($users as $user)
      <option value="{{ $user->id }}" {{ old('to_id') == $user->id || $message->receiver == $user ? 'selected' : '' }}>u/{{ $user->display_name }}</option>
    @endforeach
  </select>
  @error('to_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="title">title</label>
  <input type="text" name="title" class="form-control" id="title" value="{{ old('title') ?? $message->title }}">
  @error('title')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="content">content</label>
  <textarea class="form-control" name="content" id="content" rows="4" cols="80">{{ old('content') ?? $message->content }}</textarea>
  @error('content')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>
