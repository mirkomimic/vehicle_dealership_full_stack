<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Comment;
use App\Models\Models;
use App\Models\Vehicle;
use App\Models\VehicleImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VehicleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render('Vehicles/Index', [
      'brands' => Brand::all(),
      'models' => Models::with('vehicles')->get(),
      'years' => range(1990, date('Y'), 1),
    ]);
  }

  public function search(Request $request)
  {
    $filters = $request->only([
      'brand', 'model', 'minYear', 'maxYear', 'search', 'sort', 'mileageRange'
    ]);

    $vehicles = Vehicle::query()->with('images', function ($query) {
      return $query->where('isThumbnail', '=', true);
    })->with('model')->with('brand')->filter($filters)->paginate(9);

    return Inertia::render('Vehicles/Search', [
      'vehicles' => $vehicles,
      'filters' => $filters,
      'brands' => Brand::all(),
      'models' => Models::with('vehicles')->get(),
      'years' => range(1990, date('Y'), 1),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'model_id' => 'required',
      'price' => 'numeric|nullable',
      'mileage' => 'numeric|nullable',
      'year' => 'required',
      'images.*' => 'image|mimes:png,jpg,jpeg',
    ]);

    $vehicle = new Vehicle();
    $vehicle->model_id = $request->model_id;
    $vehicle->price = $request->price;
    $vehicle->year = $request->year;
    $vehicle->mileage = $request->mileage;
    $vehicle->user_id = Auth::id();
    $vehicle->save();

    if ($request->hasFile('images')) {
      $i = 0;
      foreach ($request->images as $img) {
        $image = new VehicleImg();
        if ($i == 0) {
          $image->isThumbnail = true;
        }
        $image->vehicle_id = $vehicle->id;
        $img->store('images/vehicles/' . $vehicle->id, 'public');
        $image->img = $img->hashName();
        $image->save();
        $i++;
      }
    }

    return redirect()->back()->with('success', 'Vehicle added!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $vehicle = Vehicle::with('images')->with('brand')->with('model')->find($id);

    $comments = Comment::query()
      ->whereNull('parent_id')
      ->where('vehicle_id', $vehicle->id)
      ->with('user')
      ->with('replies')
      ->orderBy('created_at', 'desc')
      ->get();

    return Inertia::render('Vehicles/Show', [
      'vehicle' => $vehicle,
      'comments' => $comments
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
