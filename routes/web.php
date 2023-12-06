<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//   return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.index');
  Route::get('/dashboard/brands', [AdminController::class, 'brands'])->name('dashboard.brands');
  Route::post('/dashboard/brands', [AdminController::class, 'storeBrand'])->name('dashboard.brands.store');
  Route::delete('/dashboard/brands/{id}', [AdminController::class, 'deleteBrand'])->name('dashboard.brands.delete');
  Route::post('/dashboard/brands/{id}', [AdminController::class, 'updateBrand'])->name('dashboard.brands.update');

  Route::resource('vehicles', VehicleController::class)->only('index', 'store', 'show', 'update', 'destroy');
  Route::get('vehicles_search', [VehicleController::class, 'search'])->name('vehicles.search');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
