@csrf

<div class="flex flex-wrap mb-6">
  <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
  <input onkeyup="titleCharcountUpdate(this.value)" type="title" class="bg-gray-300 form-input w-full @error('title') border-red-500 @enderror" name="title" value="{{ old('title') ?? $communityRule->title }}" required>
  @error('name')
    <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
  @enderror
</div>

<div class="mb-4">
  <span id=titleCharcount></span>
</div>

<div class="flex flex-wrap mb-6">
  <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
  <textarea onkeyup="descriptionCharcountUpdate(this.value)" class="bg-gray-300 form-input w-full @error('name') border-red-500 @enderror" name="description" id="description" rows="4" cols="80">{{ old('description') ?? $communityRule->description }}</textarea>
  @error('description')
    <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
  @enderror
</div>

<div class="mb-4">
  <span id=descriptionCharcount></span>
</div>