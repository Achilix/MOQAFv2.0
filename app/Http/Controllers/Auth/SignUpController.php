<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SignUpController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showSignUpForm()
    {
        return view('auth.signup');
    }

    /**
     * Handle registration request.
     */
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:30',
            'gov_id' => 'nullable|string|max:100',
        ]);

        // Hash the password
        $validated['password_hash'] = Hash::make($validated['password']);
        unset($validated['password']);

        // Create user
        $user = User::create($validated);

        // Log user in
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Account created successfully');
    }
}
