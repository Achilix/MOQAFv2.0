<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\Client;
use App\Models\Handyman;

class UserController extends Controller
{
    public function getCurrentUser(Request $request)
    {
        $user = $request->user()->load(['handyman', 'client']);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'fname' => $user->fname,
                'lname' => $user->lname,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
                'city' => $user->city,
                'photo' => $user->photo,
                'gov_id' => $user->gov_id,
                'is_handyman' => $user->isHandyman(),
                'is_client' => $user->isClient(),
                'handyman' => $user->handyman,
                'client' => $user->client,
            ],
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'sometimes|string|max:255',
            'lname' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|unique:users,phone_number,' . $request->user()->id,
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|integer',
            'gov_id' => 'sometimes|string',
        ]);

        $request->user()->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $request->user(),
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['photo' => $path]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
            'photo' => $path,
        ]);
    }

    public function becomeHandyman(Request $request)
    {
        $user = $request->user();

        if ($user->isHandyman()) {
            return response()->json([
                'message' => 'User is already a handyman',
            ], 400);
        }

        $validated = $request->validate([
            'services' => 'required|array|min:1',
            'bio' => 'sometimes|string|max:1000',
        ]);

        $handyman = Handyman::create([
            'handyman_id' => $user->id,
            'services' => $validated['services'],
            'bio' => $validated['bio'] ?? null,
        ]);

        return response()->json([
            'message' => 'You are now a handyman',
            'data' => $handyman,
        ], 201);
    }

    public function getHandymanProfile(Request $request)
    {
        $user = $request->user();

        if (!$user->isHandyman()) {
            return response()->json([
                'message' => 'User is not a handyman',
            ], 403);
        }

        return response()->json([
            'data' => $user->handyman->load('gigs'),
        ]);
    }

    public function updateHandymanProfile(Request $request)
    {
        $user = $request->user();

        if (!$user->isHandyman()) {
            return response()->json([
                'message' => 'User is not a handyman',
            ], 403);
        }

        $validated = $request->validate([
            'services' => 'sometimes|array',
            'bio' => 'sometimes|string|max:1000',
        ]);

        $user->handyman->update($validated);

        return response()->json([
            'message' => 'Handyman profile updated successfully',
            'data' => $user->handyman,
        ]);
    }

    public function getCountries()
    {
        $countries = Country::all();

        return response()->json([
            'data' => $countries,
        ]);
    }

    public function getCities($countryId)
    {
        $cities = City::where('country_id', $countryId)->get();

        return response()->json([
            'data' => $cities,
        ]);
    }
}
