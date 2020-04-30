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
        <button type="button" name="button" class="btn btn-blue">modifier</button>
      </div>
    </div>
    <div class="flex mb-8">
      <div>
        <h3 class="title h3">Changer le mot de passe</h3>
        <p>Le mot de pase doit contenir au minimum 8 caractères.</p>
      </div>
      <div class="ml-8">
        <a href="{{ route('user.settings.password.edit') }}"><button type="button" name="button" class="btn btn-blue">modifier</button></a>
      </div>
    </div>
    <div class="mb-8">
      
      
      
      <a class="nav-link" href="{{ route('user.settings.account.destroy') }}" onclick="event.preventDefault(); 
        document.getElementById('destroy-form').submit();"><button type="button" name="button" class="btn btn-red">Supprimer mon compte</button></a>
        
      <form id="destroy-form" action="{{ route('user.settings.account.destroy') }}" method="POST" class="hidden">
        @method('DELETE')
        @csrf
        <input type="hidden" name="key" value="{{ $key }}">
      </form>
    </div>
  </div>
@endsection