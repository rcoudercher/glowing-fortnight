<?php

namespace App\Http\Controllers\Admin;

use App\Trophy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

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
    $validator = tap(request()->validate([
      'name' => 'required|max:255|unique:trophies',
    ]), function () {
      if (request()->hasFile('image')) {
        request()->validate([
          'image' => 'file|image|max:5000'
        ]);
      }
    });
        
    $trophy = Trophy::create($validator);
    
    
    $this->storeImage($trophy);
    
    return redirect(route('admin.trophies.index'))->with('message', 'Trophy created successfully.');
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
    
    $this->storeImage($trophy);
    
    return redirect(route('admin.trophies.show', ['trophy' => $trophy]))->with('message', 'Trophy updated successfully.');
  }

  public function destroy(Trophy $trophy)
  {
    $trophy->delete();
    return redirect(route('admin.trophies.index'))->with('message', 'Trophy deleted successfully.');
  }
  
  private function storeImage($trophy)
  {
    if (request()->has('image')) {
      $trophy->update([
        'image' => request()->image->store('uploads', 'public'),
      ]);
    }
  }
}
