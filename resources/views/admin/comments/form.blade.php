@csrf

<div class="form-group">
  <label for="user_id">user_id</label>
  <input type="text" name="user_id" class="form-control" id="user_id" value="{{ old('user_id') ?? $comment->user_id }}">
  @error('user_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="post_id">post_id</label>
  <input type="text" name="post_id" class="form-control" id="post_id" value="{{ old('post_id') ?? $comment->post_id }}">
  @error('post_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="parent_id">parent_id</label>
  <input type="text" name="parent_id" class="form-control" id="parent_id" value="{{ old('parent_id') ?? $comment->parent_id }}">
  @error('parent_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="content">content</label>
  <input type="text" name="content" class="form-control" id="content" value="{{ old('content') ?? $comment->content }}">
  @error('content')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>
