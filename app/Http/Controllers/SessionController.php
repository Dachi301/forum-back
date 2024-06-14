<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function store() {
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

        request()->session()->regenerate();

        return response()->json('User logged in successfully');
    }

    public function destroy()
    {
        Auth::logout();

        return response()->json('User logged out successfully');
    }
}
