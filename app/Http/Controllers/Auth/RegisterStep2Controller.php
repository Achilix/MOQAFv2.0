<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterStep2Controller extends Controller
{
    public function show()
    {
        if (!session('register_user_id')) {
            return redirect()->route('register.step1');
        }
        return view('auth.register-step2');
    }

    public function submit(Request $request)
    {
        if (!session('register_user_id')) {
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
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $govIdPath = null;
        if ($request->hasFile('gov_id')) {
            $govIdPath = $request->file('gov_id')->store('gov_ids', 'public');
        }

        $user = User::find(session('register_user_id'));
        $user->update([
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
            'phone_number' => $validated['phone_number'],
            'user_type' => $validated['user_type'],
            'gov_id' => $govIdPath,
            'address' => $validated['address'],
            'city' => $validated['city'] ?? null,
            'photo' => $photoPath,
        ]);

        if ($validated['user_type'] === 'seller') {
            return redirect()->route('register.step3');
        } else {
            DB::table('client')->insert([
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            session()->forget(['register_user_id']);
            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        }
    }
}
