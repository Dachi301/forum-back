<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class RegisteredUserController extends Controller
{
    public function store () {
        $attributes = request()->validate([
            'username' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(6), 'confirmed']
        ]);

        User::create($attributes);

        return response()->json('User Added Successfully');
    }
}
