<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class RegisteredUserController extends Controller
{
    public function store () {
        try {
            $attributes = request()->validate([
                'username' => ['required', 'min:3', 'unique:users,username'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', Password::min(6), 'confirmed']
            ]);

            $user = User::create($attributes);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully!',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
