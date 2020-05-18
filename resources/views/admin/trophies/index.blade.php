@extends('layouts.admin')

@section('title', 'ADMIN Trophies index')

@section('content')
  <h1>Trophies index</h1>
  <p><a href="{{ route('admin.trophies.create') }}">Add new trophy</a></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">image</th>
        <th scope="col">created_at</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($trophies as $trophy)
      <tr>
        <th scope="row">{{ $trophy->id }}</th>
        <td><a href="{{ route('admin.trophies.update', ['trophy' => $trophy]) }}">{{ $trophy->name }}</a></td>
        <td>{{ $trophy->image }}</td>
        <td>{{ $trophy->created_at }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $trophies->links() }}
  </div>
@endsection
