<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\QuestionController;
use App\Models\Question;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TagController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf-token', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Auth
Route::post('/auth/signup', [RegisteredUserController::class, 'store']);
Route::post('/auth/login', [SessionController::class, 'store']);
//Route::post('/auth/logout', [SessionController::class, 'destroy']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/logout', [SessionController::class, 'destroy']);
});

// User Data
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('me', [SessionController::class, 'me']);
});

// Like and Dislike Functionality
Route::post('/questions/{questionId}/like-unlike-question', [LikeController::class, 'store'])
    ->middleware('auth');

// GET questions
Route::get('/questions', [QuestionController::class, 'index']);
Route::get('/questions/{questionId}', [QuestionController::class, 'show']);

// Upload Question
Route::post('/upload', [QuestionController::class, 'store'])->middleware('auth');

// GET Tags
Route::get('/tags', [TagController::class, 'index']);

// Comments and Replies
Route::middleware('auth')->group(function () {
    Route::post('/questions/{question}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/replies', [ReplyController::class, 'store'])->name('replies.store');
});
