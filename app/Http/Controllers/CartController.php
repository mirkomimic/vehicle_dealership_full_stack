<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    if ($request->vehicle['user_id'] == Auth::id()) {
      return false;
    }

    $cart = session()->get('cart', []);

    $this->checkIfInCart($cart, $request->vehicle['id']);

    if (!empty($cart)) {
      if ($this->checkIfInCart($cart, $request->vehicle['id'])) {
        foreach ($cart as $item) {
          if ($item->vehicle['id'] == $request->vehicle['id']) {
            $item->quantity++;
            $item->total = $item->quantity * $item->vehicle['price'];
          }
        }
      } else {
        $cart[] = (object) [
          'vehicle' => $request->vehicle,
          'quantity' => 1,
          'total' => $request->vehicle['price']
        ];
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
      if ($this->checkIfInCart($cart, $request->vehicle['id'])) {
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
    }

    session()->put('cart', $cart);
  }

  public function clear()
  {
    session()->put('cart', []);
  }

  public function checkIfInCart($cart, $vehicle_id)
  {
    $ids = [];
    foreach ($cart as $item) {
      $ids[] = $item->vehicle['id'];
    }
    if (in_array($vehicle_id, $ids)) {
      return true;
    }
    return false;
  }
}
