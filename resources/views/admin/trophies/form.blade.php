<div class="form-group">
  <label for="name">name</label>
  <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ?? $trophy->name }}">
  <small class="form-text text-muted">{{ $errors->first('name') }}</small>
</div>

@csrf