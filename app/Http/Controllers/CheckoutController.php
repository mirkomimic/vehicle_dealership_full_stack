<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CheckoutController extends Controller
{
  public function index()
  {
    $cart = session()->get('cart', []);

    $order = Order::query()->where('user_id', Auth::id())->where('payment_intent', null)->first();
    $order?->delete();

    if (!empty($cart)) {
      return Inertia::render('Checkout/Index');
    }
  }

  public function destroy()
  {
    session()->put('cart', []);

    $order = Order::query()->where('user_id', Auth::id())->where('payment_intent', null)->first();
    $order?->delete();

    return redirect('/');
  }
}
