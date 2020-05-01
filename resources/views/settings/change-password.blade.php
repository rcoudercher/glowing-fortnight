@extends('layouts.app')

@section('content')
  
<div class="bg-gray-300 h-screen">
  <div class="container mx-auto pt-8">
    
    @if (session()->has('message'))
      <div class="shadow rounded p-4 mb-8 bg-red-300">
        <div class="text-red-900 text-center"><strong>{{ session()->get('message') }}</strong></div>
      </div>
    @endif
    
    
    <div class="flex flex-wrap justify-center">
      <div class="w-full max-w-sm">
        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
          <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">Changement de votre de passe</div>
          <form class="w-full p-6" method="POST" action="{{ route('user.settings.password.update') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="flex flex-wrap mb-6">
              <label for="old_password" class="block text-gray-700 text-sm font-bold mb-2">Ancien mot de passe :</label>
              <input id="old_password" type="password" class="form-input w-full @error('old_password') border-red-500 @enderror" name="old_password" required>
              @error('old_password')
                <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex flex-wrap mb-6">
              <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Nouveau mot de passe :</label>
              <input id="password" type="password" class="form-input w-full @error('password') border-red-500 @enderror" name="password" required>
              @error('password')
                <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex flex-wrap mb-6">
              <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">Confirmer le nouveau mot de passe :</label>
              <input id="password-confirm" type="password" class="form-input w-full" name="password_confirmation" required>
            </div>
            <div class="flex flex-wrap">
              <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold  py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
