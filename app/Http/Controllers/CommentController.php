<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store (Request $request, Question $question)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $question->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        return response()->json(['success' => true], 200);
    }
}
