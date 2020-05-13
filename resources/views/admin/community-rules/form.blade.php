@csrf

<div class="form-group">
  <label for="creator_id">creator</label>
  <select class="custom-select" name="creator_id">
    <option>select user</option>
    @foreach ($users as $user)
      <option value="{{ $user->id }}" {{ old('creator_id') == $user->id || $communityRule->creator == $user ? 'selected' : '' }}>u/{{ $user->display_name }}</option>
    @endforeach
  </select>
  @error('creator_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="community_id">community</label>
  <select class="custom-select" name="community_id">
    <option>select community</option>
    @foreach ($communities as $community)
      <option value="{{ $community->id }}" {{ old('community_id') == $community->id || $communityRule->community == $community ? 'selected' : '' }}>k/{{ $community->display_name }}</option>
    @endforeach
  </select>
  @error('community_id')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="order">order</label>
  <input type="number" min="1" max="20" name="order" class="form-control" id="order" value="{{ old('order') ?? $communityRule->order }}">
  @error('order')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="title">title</label>
  <input type="text" name="title" class="form-control" id="title" value="{{ old('title') ?? $communityRule->title }}" required>
  @error('title')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="description">description</label>
  <textarea class="form-control" name="description" id="description" rows="4" cols="80">{{ old('description') ?? $communityRule->description }}</textarea>
  @error('description')
    <small class="form-text text-muted">{{ $message }}</small>
  @enderror
</div>

