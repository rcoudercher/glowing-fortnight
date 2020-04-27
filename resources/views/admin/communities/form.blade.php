@csrf

<div class="form-group">
  <label for="name">name</label>
  <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ?? $community->name }}" required autofocus>
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
