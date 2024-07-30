<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function store()
    {
        // Login Logic
        try {
            // validate
            $attributes = request()->validate([
                'username' => ['required'],
                'password' => ['required']
            ]);

            if (!Auth::attempt($attributes)) {
                // throw ValidationException::withMessages([
                // 'email' => 'Sorry, those credentials do not match.',
                // ]);
                return response()->json('Sorry, those credentials do not match', 401);
            }

//            request()->session()->regenerate();

            $user = User::where('username', request()->username)->first();

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function me()
    {
        $userData = auth()->user();

        return response()->json([
            'data' => $userData
        ]);
    }

    public function destroy()
    {
        // Logout Logic
        $user = auth()->user();

        if ($user) {
            $user->tokens()->delete();
            return response([
                'message' => 'Successfully logged out'
            ], 200);
        }

        return response([
            'message' => 'No authenticated user'
        ], 401);
    }
}
