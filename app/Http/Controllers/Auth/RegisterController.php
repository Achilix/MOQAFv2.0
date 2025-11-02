<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showStep1()
    {
        return view('auth.register-step1');
    }

    public function submitStep1(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        session([
            'register_email' => $validated['email'],
            'register_password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('register.step2');
    }

    public function showStep2()
    {
        if (!session('register_email')) {
            return redirect()->route('register.step1');
        }

        return view('auth.register-step2');
    }

    public function submitStep2(Request $request)
    {
        if (!session('register_email')) {
            return redirect()->route('register.step1');
        }

        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'user_type' => 'required|in:buyer,seller',
            'gov_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string', // add password validation
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $govIdPath = null;
        if ($request->hasFile('gov_id')) {
            $govIdPath = $request->file('gov_id')->store('gov_ids', 'public');
        }

        $user = User::create([
            'email' => session('register_email'),
            'password' => $validated['password'],
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
            'phone_number' => $validated['phone_number'],
            'user_type' => $validated['user_type'],
            'gov_id' => $govIdPath,
            'address' => $validated['address'],
            'city' => $validated['city'] ?? null,
            'photo' => $photoPath,
        ]);

        // Store user ID in session for step 3
        session(['register_user_id' => $user->id]);

        // If seller, go to step 3; if buyer, create client record and finish
        if ($validated['user_type'] === 'seller') {
            return redirect()->route('register.step3');
        } else {
            DB::table('client')->insert([
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->forget(['register_email', 'register_password', 'register_user_id']);

            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        }
    }

    public function showStep3()
    {
        if (!session('register_user_id')) {
            return redirect()->route('register.step1');
        }

        return view('auth.register-step3');
    }

    public function submitStep3(Request $request)
    {
        if (!session('register_user_id')) {
            return redirect()->route('register.step1');
        }

        $validated = $request->validate([
            'services' => 'nullable|string|max:1000',
            'bio' => 'nullable|string|max:1000',
        ]);

        DB::table('handyman')->insert([
            'handyman_id' => session('register_user_id'),
            'services' => $validated['services'],
            'bio' => $validated['bio'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->forget(['register_email', 'register_password', 'register_user_id']);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}
