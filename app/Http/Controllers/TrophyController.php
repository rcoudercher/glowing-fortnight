<?php

namespace App\Http\Controllers;

use App\Trophy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TrophyController extends Controller
{
  public function index()
  {
    $trophies = Trophy::paginate(20);
    return view('admin.trophies.index', compact('trophies'));
  }

  public function create()
  {
    $trophy = new Trophy(); // passes an empty model to the view
    return view('admin.trophies.create', compact('trophy'));
  }

  public function store(Request $request)
  {
    $validator = request()->validate([
      'name' => 'required|max:255|unique:trophies',
    ]);
    Trophy::create($validator);
    return redirect(route('trophies.index'))->with('message', 'Trophy created successfully.');
  }

  public function show(Trophy $trophy)
  {
    return view('admin.trophies.show', compact('trophy'));
  }

  public function edit(Trophy $trophy)
  {
    return view('admin.trophies.edit', compact('trophy'));
  }

  public function update(Request $request, Trophy $trophy)
  {
    $validator = Validator::make($request->all(), [
      'name' => ['required', Rule::unique('trophies')->ignore($trophy)],
    ])->validate();
    
    $trophy->update($validator);
    
    return redirect(route('trophies.show', ['trophy' => $trophy]))->with('message', 'Trophy updated successfully.');
  }

  public function destroy(Trophy $trophy)
  {
    $trophy->delete();
    return redirect(route('trophies.index'))->with('message', 'Trophy deleted successfully.');
  }
}
