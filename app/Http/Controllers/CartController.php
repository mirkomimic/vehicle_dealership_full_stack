<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $cart = session()->get('cart', []);

    if (!empty($cart)) {
      foreach ($cart as $item) {
        if ($item->vehicle['id'] == $request->vehicle['id']) {
          $item->quantity++;
          $item->total = $item->quantity * $item->vehicle['price'];
        } else {
          $cart[] = (object) [
            'vehicle' => $request->vehicle,
            'quantity' => 1,
            'total' => $request->vehicle['price']
          ];
        }
      }
    } else {
      $cart[] = (object) [
        'vehicle' => $request->vehicle,
        'quantity' => 1,
        'total' => $request->vehicle['price']
      ];
    }

    session()->put('cart', $cart);
  }

  public function remove(Request $request)
  {
    $cart = session()->get('cart', []);

    if (!empty($cart)) {
      foreach ($cart as $key => $item) {
        if ($item->vehicle['id'] == $request->vehicle['id']) {
          if ($item->quantity > 1) {
            $item->quantity--;
            $item->total = $item->quantity * $item->vehicle['price'];
          } else {
            unset($cart[$key]);
          }
        }
      }
    }

    session()->put('cart', $cart);
  }

  public function clear()
  {
    session()->put('cart', []);
  }
}
