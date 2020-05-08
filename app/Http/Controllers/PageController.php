<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
  public function test()
  {
    return view('pages.test');
  }
  
  public function test2()
  {
    return view('pages.test');
  }
}
