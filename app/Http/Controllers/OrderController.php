<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Stripe\StripeClient;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $stripe = new StripeClient(env('STRIPE_SECRET'));

    $order = Order::query()->where('user_id', Auth::id())->where('payment_intent', null)->first();

    $intent = $stripe->paymentIntents->create([
      'amount' => (int) $order->total,
      'currency' => 'usd',
      'payment_method_types' => ['card'],
    ]);

    return Inertia::render('Orders/Create', [
      'intent' => $intent,
      'order' => $order,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $cart = session()->get('cart', []);

    // order without intent here

    if (!empty($cart)) {
      return Inertia::render('Orders/Create');
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $cart = session()->get('cart', []);

    if (empty($cart)) return false;

    $order = Order::query()->where('user_id', Auth::id())->where('payment_intent', null)->first();

    if (!is_null($order)) {
      $order->total = $request->grandTotal;
      $order->total_decimal = $request->grandTotalDecimal;
      $order->items = json_encode($cart);
      $order->save();
    } else {
      $order = new Order();
      $order->user_id = Auth::id();
      $order->total = $request->grandTotal;
      $order->total_decimal = $request->grandTotalDecimal;
      $order->items = json_encode($cart);
      $order->save();
    }

    session()->put('cart', []);

    // return Inertia::render('Orders/Complete');
    return redirect()->route('orders.index');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $order = Order::query()->where('user_id', Auth::id())->where('payment_intent', null)->first();

    $order->payment_intent = $request->payment_intent;
    $order->save();

    // return Inertia::render('Orders/Complete');
    return redirect()->route('orders.success');
  }

  public function complete()
  {
    return Inertia::render('Orders/Complete');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
