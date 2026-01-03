<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterStep1Controller extends Controller
{
    public function show()
    {
        return view('auth.register-step1');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'agree_terms' => 'required|accepted',
        ], [
            'agree_terms.required' => 'You must agree to the terms and conditions to continue.',
            'agree_terms.accepted' => 'You must agree to the terms and conditions to continue.',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        session(['register_user_id' => $user->id]);

        return redirect()->route('register.step2');
    }
}
