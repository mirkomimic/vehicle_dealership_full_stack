<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
  public function search(Request $request)
  {
    // if ($request->keyword == '') {
    //   return response()->json(['result' => 'No Results']);
    // }

    // $request->validate([
    //   'keyword' => 'required',
    // ]);

    $validator = Validator::make($request->all(), [
      'keyword' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['message' => 'The keyword field is required.']);
    }

    $brands = Brand::query()->where('name', 'like', '%' . $request->keyword . '%')->get();
    $models = Models::query()->where('name', 'like', '%' . $request->keyword . '%')->with('brand')->get();

    return response()->json([
      'brands' => $brands,
      'models' => $models,
    ]);
  }
}
