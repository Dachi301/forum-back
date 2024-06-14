<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, $questionId) {
        $user = $request->user();

        $like = Like::where('user_id', $user->id)
                    ->where('question_id', $questionId)
                    ->first();

        if ($like) {
            $like->delete();
            return response()->json(['success' => true, 'message' => 'You unliked a question.'], 200);
        } else {
            $like = new Like();
            $like->user_id = $user->id;
            $like->question_id = $questionId;

            if ($like->save()) {
                return response()->json([
                    'message' => 'You liked a Post',
                    'like' => $like
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Some error occurred, Please try again!'
                ], 500);
            }
        }
    }
}
