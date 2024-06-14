<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(['user', 'likes.user', 'tags', 'comments.replies'])->get();
        return response()->json($questions);
    }

    public function show($id)
    {
        $question = Question::with(['user', 'tags'])->findOrFail($id);
        return response()->json($question);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required', 'min:5'],
            'question' => ['required'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'tags' => ['array', 'exists:tags,id']
        ]);

        $userId = Auth::id();

        $question = Question::create([
            'title' => $attributes['title'],
            'question' => $attributes['question'],
            'user_id' => $userId,
            'image' => $request->file('image') ? $request->file('image')->store('images') : null,
        ]);

        $tags = $attributes['tags'] ?? [];
        $question->tags()->attach($tags);

        return response()->json([
            'success' => true,
            'question' => $question->load('tags')
        ]);
    }
}
