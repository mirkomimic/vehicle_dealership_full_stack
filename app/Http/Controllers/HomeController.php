<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function index()
  {

    return Inertia::render('Home', [
      'brands' => Brand::all(),
      'models' => Models::all(),
    ]);
  }
}
