<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gig;
use App\Models\Handyman;

class GigController extends Controller
{
    public function index(Request $request)
    {
        $gigs = Gig::with('handymen')
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', "%{$request->search}%")
                      ->orWhere('description', 'like', "%{$request->search}%");
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->paginate(15);

        return response()->json([
            'data' => $gigs->items(),
            'pagination' => [
                'total' => $gigs->total(),
                'per_page' => $gigs->perPage(),
                'current_page' => $gigs->currentPage(),
                'last_page' => $gigs->lastPage(),
            ],
        ]);
    }

    public function show($id)
    {
        $gig = Gig::with('handymen')->findOrFail($id);

        return response()->json([
            'data' => $gig,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->isHandyman()) {
            return response()->json([
                'message' => 'Only handymen can create gigs',
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'required|string',
            'photos' => 'nullable|array',
        ]);

        $gig = Gig::create($validated);

        return response()->json([
            'message' => 'Gig created successfully',
            'data' => $gig,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $gig = Gig::findOrFail($id);

        // Check if gig belongs to user's handyman profile
        if (!$gig->handymen->contains($user->handyman)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'type' => 'sometimes|string',
            'description' => 'sometimes|string',
            'photos' => 'nullable|array',
        ]);

        $gig->update($validated);

        return response()->json([
            'message' => 'Gig updated successfully',
            'data' => $gig,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $gig = Gig::findOrFail($id);

        // Check authorization
        if (!$gig->handymen->contains($user->handyman)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $gig->delete();

        return response()->json([
            'message' => 'Gig deleted successfully',
        ]);
    }

    public function myGigs(Request $request)
    {
        $user = $request->user();

        if (!$user->isHandyman()) {
            return response()->json([
                'message' => 'User is not a handyman',
            ], 403);
        }

        $gigs = $user->handyman->gigs()->paginate(15);

        return response()->json([
            'data' => $gigs->items(),
            'pagination' => [
                'total' => $gigs->total(),
                'per_page' => $gigs->perPage(),
                'current_page' => $gigs->currentPage(),
                'last_page' => $gigs->lastPage(),
            ],
        ]);
    }

    public function apply(Request $request, $id)
    {
        $user = $request->user();
        $gig = Gig::findOrFail($id);

        if (!$user->isHandyman()) {
            return response()->json([
                'message' => 'Only handymen can apply for gigs',
            ], 403);
        }

        // Attach handyman to gig (if not already attached)
        if (!$gig->handymen->contains($user->handyman)) {
            $gig->handymen()->attach($user->handyman->handyman_id);
        }

        return response()->json([
            'message' => 'Applied to gig successfully',
            'data' => $gig->fresh(['handymen']),
        ]);
    }
}
