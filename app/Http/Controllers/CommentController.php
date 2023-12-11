<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CommentController extends Controller
{
  public function store(Request $request)
  {
    $comment = new Comment();
    $comment->vehicle_id = $request->vehicle_id;
    $comment->user_id = Auth::id();
    $comment->comment = $request->comment;
    $comment->save();

    return redirect()->back();
  }

  public function reply(Request $request)
  {
    $comment = new Comment();
    $comment->vehicle_id = $request->vehicle_id;
    $comment->user_id = Auth::id();
    $comment->parent_id = $request->parent_id;
    $comment->comment = $request->reply;
    $comment->save();

    return redirect()->back();
  }
}
