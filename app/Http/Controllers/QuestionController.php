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
        $questions = Question::with(['user', 'likes.user', 'tags', 'comments.replies'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($questions, 200);
    }

    public function show($id)
    {
        $question = Question::with(['user', 'tags', 'likes'])->findOrFail($id);
        return response()->json($question, 200);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required', 'min:10'],
            'question' => ['required', 'min:10'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'tags' => ['array', 'exists:tags,id']
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated.',
                'id' => $userId
            ], 401);
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
        }

        $question = Question::create([
            'title' => $attributes['title'],
            'question' => $attributes['question'],
            'user_id' => $userId,
            'image' => $imageName,
        ]);

        if (isset($attributes['tags']) && is_array($attributes['tags'])) {
            $question->tags()->attach($attributes['tags']);
        }

        return response()->json([
            'success' => true,
            'question' => $question->load('tags')
        ], 201);
    }
}
