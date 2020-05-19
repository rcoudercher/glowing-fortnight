<div class="form-group">
  <label for="creator_id">creator_id</label>
  <input type="text" name="creator_id" class="form-control" id="creator_id" value="{{ old('creator_id') ?? $community->creator_id }}" required autofocus>
  @error('creator_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="type">type</label>
  <input type="text" name="type" class="form-control" id="type" value="{{ old('type') ?? $community->type }}" required>
  @error('type')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="name">name</label>
  <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ?? $community->name }}" required>
  @error('name')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="title">title</label>
  <input type="text" name="title" class="form-control" id="title" value="{{ old('title') ?? $community->title }}">
  @error('title')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="description">description</label>
  <textarea class="form-control" name="description" id="description" rows="4" cols="80">{{ old('description') ?? $community->description }}</textarea>
  @error('description')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="submission_text">submission_text</label>
  <textarea class="form-control" name="submission_text" id="submission_text" rows="4" cols="80">{{ old('submission_text') ?? $community->submission_text }}</textarea>
  @error('submission_text')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>


