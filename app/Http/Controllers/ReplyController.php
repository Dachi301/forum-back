<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store (Request $request, Comment $comment)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $comment->replies()->create([
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        return response()->json(['success' => true], 200);
    }
}
