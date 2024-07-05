<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function store()
    {
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
                return response()->json('Sorry, those credentials do not match');
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
            'status' => true,
            'message' => 'Profile info',
            'data' => $userData,
            'id' => auth()->user()->id
        ]);
    }

    public function destroy()
    {
//        Auth::logout();
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
            'data' => []
        ]);
    }
}
