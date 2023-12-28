<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function getToken(Request $request)
  {
    $user = User::where('id', $request->id)->first();
    // $user = User::where('id', Auth::id())->first();
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
      'token' => $token
    ]);
  }
}
