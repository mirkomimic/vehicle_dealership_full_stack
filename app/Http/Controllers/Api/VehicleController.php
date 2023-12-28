<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
  public function search(Request $request)
  {
    $filters = $request->only([
      'brand', 'model', 'minYear', 'maxYear', 'search', 'sort', 'mileageRange', 'type'
    ]);

    $vehicles = Vehicle::query()->with('images', function ($query) {
      return $query->where('isThumbnail', '=', true);
    })->with('model')
      ->with('brand')
      ->with('type')
      ->filter($filters)
      ->get();


    return response()->json([
      'vehicles' => count($vehicles)
    ]);
  }
}
