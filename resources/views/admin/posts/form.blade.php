<div class="form-group">
  <label for="user_id">user_id</label>
  <input type="text" name="user_id" class="form-control" id="user_id" value="{{ old('user_id') ?? $post->user_id }}">
  @error('user_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="community_id">community_id</label>
  <input type="text" name="community_id" class="form-control" id="community_id" value="{{ old('community_id') ?? $post->community_id }}">
  @error('community_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<p>notification</p>
<div class="form-group">
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="notification" id="notification_false" value="0" {{ $post->notification == 0 ? 'checked' : '' }}>
    <label class="form-check-label" for="notification_false">false</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="notification" id="notification_true" value="1" {{ $post->notification == 1 ? 'checked' : '' }}>
    <label class="form-check-label" for="notification_true">true</label>
  </div>
</div>

<p>public</p>
<div class="form-group">
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="public" id="public_false" value="0" {{ $post->public == 0 ? 'checked' : '' }}>
    <label class="form-check-label" for="public_false">false</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="public" id="public_true" value="1" {{ $post->public == 1 ? 'checked' : '' }}>
    <label class="form-check-label" for="public_true">true</label>
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

@csrf