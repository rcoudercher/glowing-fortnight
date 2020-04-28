@csrf

<div class="form-group">
  <label for="name">name</label>
  <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ?? $trophy->name }}">
  @error('name')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group d-flex flex-column">
  <label for="image">image</label>
  <input type="file" name="image" class="py-2">
  @error('image')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>
