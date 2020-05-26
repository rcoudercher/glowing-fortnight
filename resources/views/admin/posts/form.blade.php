<div class="form-group">
  <label for="user_id">user</label>
  <select class="custom-select" name="user_id">
    <option>select user</option>
    @foreach ($users as $user)
      <option value="{{ $user->id }}" {{ old('user_id') == $user->id || $post->user == $user ? 'selected' : '' }}>u/{{ $user->display_name }}</option>
    @endforeach
  </select>
  @error('user_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="community_id">community</label>
  <select class="custom-select" name="community_id">
    <option>select community</option>
    @foreach ($communities as $community)
      <option value="{{ $community->id }}" {{ old('community_id') == $community->id || $post->community == $community ? 'selected' : '' }}>k/{{ $community->display_name }}</option>
    @endforeach
  </select>
  @error('community_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<p>status</p>
<div class="form-group">
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="status" id="status_0" value="0" {{ $post->status == 0 ? 'checked' : '' }}>
    <label class="form-check-label" for="status_0">pending</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="status" id="status_1" value="1" {{ $post->status == 1 ? 'checked' : '' }}>
    <label class="form-check-label" for="status_1">approved</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="status" id="status_2" value="2" {{ $post->status == 2 ? 'checked' : '' }}>
    <label class="form-check-label" for="status_2">rejected</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="status" id="status_3" value="3" {{ $post->status == 3 ? 'checked' : '' }}>
    <label class="form-check-label" for="status_3">postponed</label>
  </div>
</div>

<div class="form-group">
  <label for="title">title</label>
  <input type="text" name="title" class="form-control" id="title" value="{{ old('title') ?? $post->title }}">
  @error('title')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="content">content</label>
  <textarea class="form-control" name="content" id="content" rows="4" cols="80">{{ old('content') ?? $post->content }}</textarea>
  @error('content')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>
