<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Models;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function index()
  {
    $latestVehicles = Vehicle::with(['images' => function ($query) {
      return $query->where('isThumbnail', '=', true);
    }])->with('model')->with('brand')->latest()->limit(5)->get();

    // dd($latestVehicles->toArray());
    return Inertia::render('Home', [
      'brands' => Brand::all(),
      'models' => Models::with('vehicles')->get(),
      'latestVehicles' => $latestVehicles,
      'years' => range(1990, date('Y'), 1),
    ]);
  }
}
