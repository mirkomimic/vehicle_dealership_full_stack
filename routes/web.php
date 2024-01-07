<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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

Route::get('vehicles_search', [VehicleController::class, 'search'])->name('vehicles.search');
Route::resource('vehicles', VehicleController::class)->only('show');


Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.index');
  Route::get('/dashboard/brands', [AdminController::class, 'brands'])->name('dashboard.brands');
  Route::post('/dashboard/brands', [AdminController::class, 'storeBrand'])->name('dashboard.brands.store');
  Route::delete('/dashboard/brands/{id}', [AdminController::class, 'deleteBrand'])->name('dashboard.brands.delete');
  Route::post('/dashboard/brands/{id}', [AdminController::class, 'updateBrand'])->name('dashboard.brands.update');

  Route::resource('vehicles', VehicleController::class)->only('index', 'store', 'update', 'destroy');

  Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
  Route::post('/reply', [CommentController::class, 'reply'])->name('comment.reply');

  Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
  Route::post('/cart_remove', [CartController::class, 'remove'])->name('cart.remove');
  Route::post('/cart_clear', [CartController::class, 'clear'])->name('cart.clear');

  Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
  Route::get('/checkout_cancel', [CheckoutController::class, 'destroy'])->name('checkout.destroy');

  Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'update']);
  Route::get('/order_complete', [OrderController::class, 'complete'])->name('orders.success');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
