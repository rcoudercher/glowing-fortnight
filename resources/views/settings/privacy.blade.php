@extends('layouts.user-settings')

@section('title', 'Sécurité / Configuration')

@section('section-title', 'Sécurité')

@section('section')
  <div>
    <div class="flex my-3">
      <div>
        <h4 class="title h4">Security setting 1</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
      </div>
      <div class="ml-8">
        <input class="apple-switch" type="checkbox">
      </div>
    </div>
    
    <div class="flex my-3">
      <div>
        <h4 class="title h4">Security setting 2</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
      </div>
      <div class="ml-8">
        <input class="apple-switch" type="checkbox" checked>
      </div>
    </div>
    
    <div class="flex my-3">
      <div>
        <h4 class="title h4">Security setting 3</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
      </div>
      <div class="ml-8">
        <input class="apple-switch" type="checkbox">
      </div>
    </div>
    
    <div class="flex my-3">
      <div>
        <h4 class="title h4">Security setting 4</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
      </div>
      <div class="ml-8">
        <input class="apple-switch" type="checkbox" checked>
      </div>
    </div>
    
  </div>
@endsection
