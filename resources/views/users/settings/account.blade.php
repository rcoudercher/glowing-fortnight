@extends('layouts.user-settings')

@section('title', 'Compte / Configuration')

@section('section-title', 'Compte')

@section('section')
  <div>
    <div class="flex mb-8">
      <div>
        <h3 class="title h3">Adresse e-mail</h3>
        <div>{{ Auth::user()->email }}</div>
      </div>
      <div class="ml-8">
        <a href="#" class="btn btn-blue">Modifier</a>
      </div>
    </div>
    <div class="flex mb-8">
      <div>
        <h3 class="title h3">Changer le mot de passe</h3>
        <p>Le mot de pase doit contenir au minimum 8 caractères.</p>
      </div>
      <div class="ml-8">
        <a class="btn btn-blue" href="{{ route('user.settings.password.edit') }}">modifier</a>
      </div>
    </div>
    <div class="mb-8">
      
      
      
      <a class="btn btn-red" href="{{ route('user.settings.account.destroy') }}" onclick="event.preventDefault(); 
        document.getElementById('destroy-form').submit();">Supprimer mon compte</a>
      <form id="destroy-form" action="{{ route('user.settings.account.destroy') }}" method="POST" class="hidden">
        @method('DELETE')
        @csrf
        <input type="hidden" name="key" value="{{ $key }}">
      </form>
    </div>
  </div>
@endsection
