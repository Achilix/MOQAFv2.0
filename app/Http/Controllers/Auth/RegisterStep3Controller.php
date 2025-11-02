<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterStep3Controller extends Controller
{
    public function show()
    {
        if (!session('register_user_id')) {
            return redirect()->route('register.step1');
        }

        $serviceOptions = [
            'painting' => 'Painting',
            'carpentry' => 'Carpentry',
            'cleaning' => 'Cleaning',
            'gardening' => 'Gardening',
            'moving' => 'Moving',
            'appliance_repair' => 'Appliance Repair',
        ];

        $oldServices = old('services', []);

        return view('auth.register-step3', compact('serviceOptions', 'oldServices'));
    }

    public function submit(Request $request)
    {
        if (!session('register_user_id')) {
            return redirect()->route('register.step1');
        }

        $validated = $request->validate([
            'services' => 'required|array|min:1',
            'services.*' => 'string|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);

        DB::table('handyman')->insert([
            'handyman_id' => session('register_user_id'),
            'services' => json_encode($validated['services']),
            'bio' => $validated['bio'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->forget(['register_user_id']);
        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');
    }
}
