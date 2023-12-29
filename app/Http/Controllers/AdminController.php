<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware(['admin']);
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $breadcrumbs = [
      (object) [
        'title' => 'Dashboard',
        'href' => 'dashboard.index',
        'disabled' => true
      ]
    ];

    return Inertia::render('Dashboard/Index', [
      'breadcrumbs' => $breadcrumbs,
    ]);
  }

  public function brands()
  {
    $breadcrumbs = [
      (object) [
        'title' => 'Dashboard',
        'href' => 'dashboard.index',
        'disabled' => false
      ],
      (object) [
        'title' => 'Brands',
        'href' => 'dashboard.brands',
        'disabled' => true
      ],
    ];

    return Inertia::render('Dashboard/Brands', [
      'brands' => Brand::all(),
      'breadcrumbs' => $breadcrumbs
    ]);
  }

  public function storeBrand(Request $request)
  {
    // dd($request);
    $request->validate([
      'name' => 'required',
      'image' => 'mimes:png,jpg,jpeg|nullable',
    ]);

    $brand = new Brand();
    $brand->name = $request->name;

    if ($request->hasFile('image')) {
      $request->image->store('images/brands', 'public');
      $brand->image = $request->image->hashName();
    }
    $brand->save();

    return redirect()->back()->with('success', 'Brand added!');
  }

  public function deleteBrand($id)
  {
    $brand = Brand::find($id);

    if (Storage::exists("public/images/brands/" . $brand->image)) {
      Storage::delete("public/images/brands/" . $brand->image);
    }

    $brand->delete();

    return redirect()->back()->with('success', 'Brand deleted!');
  }

  public function updateBrand(Request $request, int $id)
  {
    $brand = Brand::find($id);
    $brand->name = $request->name;

    if ($request->hasFile('image')) {
      if (Storage::exists("public/images/brands/" . $brand->image)) {
        Storage::delete("public/images/brands/" . $brand->image);
      }

      $request->image->store('images/brands', 'public');
      $brand->image = $request->image->hashName();
    }

    $brand->save();

    return redirect()->back()->with('success', 'Brand updated!');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
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
