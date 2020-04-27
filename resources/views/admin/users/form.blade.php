@csrf

<div class="form-group">
  <label for="name">{{ __('Name') }}</label>
  <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>
  @error('name')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="email">{{ __('E-Mail Address') }}</label>
  <input type="email" name="email" class="form-control" id="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email">
  @error('email')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="description">description</label>
  <textarea class="form-control" name="description" id="description" rows="4" cols="80">{{ old('description') ?? $user->description }}</textarea>
  @error('description')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<p>Trophies</p>
<div class="form-group">
  @foreach ($trophies as $trophy)
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="trophies[]" value="{{ $trophy->id }}" id="badge-{{ $trophy->id }}" {{ $user->trophies->contains($trophy->id) ? 'checked' : '' }}>
      <label class="form-check-label" for="badge-{{ $trophy->id }}">{{ $trophy->name }}</label>
    </div>
  @endforeach
</div>
