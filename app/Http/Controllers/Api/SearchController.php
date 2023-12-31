<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function search(Request $request)
  {
    if ($request->keyword == '') {
      return response()->json(['result' => 'No Results']);
    }

    $brands = Brand::query()->where('name', 'like', '%' . $request->keyword . '%')->get();
    $models = Models::query()->where('name', 'like', '%' . $request->keyword . '%')->get();

    return response()->json([
      'brands' => $brands,
      'models' => $models,
    ]);
  }
}
