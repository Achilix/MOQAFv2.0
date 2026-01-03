<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gig;
use App\Models\GigTier;
use Illuminate\Support\Facades\DB;

class TierController extends Controller
{
    /**
     * Get all tiers for a specific gig
     */
    public function getTiersByGig($gigId)
    {
        $gig = Gig::findOrFail($gigId);
        $tiers = GigTier::where('id_gig', $gigId)->get();

        return response()->json([
            'data' => $tiers,
        ]);
    }

    /**
     * Create a new tier for a gig
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'id_gig' => 'required|exists:gigs,id_gig',
            'tier_name' => 'required|in:BASIC,MEDIUM,PREMIUM',
            'description' => 'required|string|max:500',
            'base_price' => 'required|numeric|min:0.01',
            'delivery_days' => 'required|integer|min:1',
        ]);

        $gig = Gig::findOrFail($validated['id_gig']);

        // Check if user is the owner of this gig
        if (!$gig->handymen->contains($user->handyman)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Check if tier already exists
        $existingTier = GigTier::where('id_gig', $validated['id_gig'])
            ->where('tier_name', $validated['tier_name'])
            ->first();

        if ($existingTier) {
            return response()->json([
                'message' => 'This tier already exists for this gig',
            ], 422);
        }

        $tier = GigTier::create($validated);

        return response()->json([
            'message' => 'Tier created successfully',
            'data' => $tier,
        ], 201);
    }

    /**
     * Update a tier
     */
    public function update(Request $request, $tierId)
    {
        $user = $request->user();
        $tier = GigTier::findOrFail($tierId);
        $gig = $tier->gig;

        // Check authorization
        if (!$gig->handymen->contains($user->handyman)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'tier_name' => 'sometimes|in:BASIC,MEDIUM,PREMIUM',
            'description' => 'sometimes|string|max:500',
            'base_price' => 'sometimes|numeric|min:0.01',
            'delivery_days' => 'sometimes|integer|min:1',
        ]);

        // Check if new tier_name already exists (if being changed)
        if (isset($validated['tier_name']) && $validated['tier_name'] !== $tier->tier_name) {
            $exists = GigTier::where('id_gig', $gig->id_gig)
                ->where('tier_name', $validated['tier_name'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'This tier already exists for this gig',
                ], 422);
            }
        }

        $tier->update($validated);

        return response()->json([
            'message' => 'Tier updated successfully',
            'data' => $tier,
        ]);
    }

    /**
     * Delete a tier
     */
    public function destroy(Request $request, $tierId)
    {
        $user = $request->user();
        $tier = GigTier::findOrFail($tierId);
        $gig = $tier->gig;

        // Check authorization
        if (!$gig->handymen->contains($user->handyman)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Check that gig has at least one tier remaining
        $tierCount = GigTier::where('id_gig', $gig->id_gig)->count();
        if ($tierCount <= 1) {
            return response()->json([
                'message' => 'A gig must have at least one pricing tier',
            ], 422);
        }

        $tier->delete();

        return response()->json([
            'message' => 'Tier deleted successfully',
        ]);
    }
}
