<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gig;
use App\Models\Handyman;
use App\Models\GigTier;
use Illuminate\Support\Facades\DB;

class GigController extends Controller
{
    public function index(Request $request)
    {
        $gigs = Gig::with(['handymen', 'tiers'])
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
        $gig = Gig::with(['handymen', 'tiers'])->findOrFail($id);

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
            'tiers' => 'required|array|min:1',
            'tiers.*.tier_name' => 'required|in:BASIC,MEDIUM,PREMIUM',
            'tiers.*.description' => 'required|string',
            'tiers.*.base_price' => 'required|numeric|min:0',
            'tiers.*.delivery_days' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $gig = Gig::create([
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'photos' => $validated['photos'] ?? null,
            ]);

            // Create pricing tiers
            foreach ($validated['tiers'] as $tier) {
                GigTier::create([
                    'id_gig' => $gig->id_gig,
                    'tier_name' => $tier['tier_name'],
                    'description' => $tier['description'],
                    'base_price' => $tier['base_price'],
                    'delivery_days' => $tier['delivery_days'],
                ]);
            }

            'tiers' => 'sometimes|array|min:1',
            'tiers.*.tier_name' => 'required_with:tiers|in:BASIC,MEDIUM,PREMIUM',
            'tiers.*.description' => 'required_with:tiers|string',
            'tiers.*.base_price' => 'required_with:tiers|numeric|min:0',
            'tiers.*.delivery_days' => 'required_with:tiers|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $gig->update([
                'title' => $validated['title'] ?? $gig->title,
                'type' => $validated['type'] ?? $gig->type,
                'description' => $validated['description'] ?? $gig->description,
                'photos' => $validated['photos'] ?? $gig->photos,
            ]);

            // Update tiers if provided
            if (isset($validated['tiers'])) {
                // Delete existing tiers
                GigTier::where('id_gig', $gig->id_gig)->delete();

                // Create new tiers
                foreach ($validated['tiers'] as $tier) {
                    GigTier::create([
                        'id_gig' => $gig->id_gig,
                        'tier_name' => $tier['tier_name'],
                        'description' => $tier['description'],
                        'base_price' => $tier['base_price'],
                        'delivery_days' => $tier['delivery_days'],
                    ]);
                }
            }

            $gig->load('tiers');

            DB::commit();

            return response()->json([
                'message' => 'Gig updated successfully',
                'data' => $gig,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update gig',
                'error' => $e->getMessage(),
            ], 500);
        } ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create gig',
                'error' => $e->getMessage(),
            ], 500);
        }
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
            'duration' => 'sometimes|string',
            'location' => 'sometimes|string',
            'availability' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'tiers' => 'sometimes|array',
            'tiers.*.description' => 'sometimes|string',
            'tiers.*.base_price' => 'sometimes|numeric|min:0.01',
            'tiers.*.delivery_days' => 'sometimes|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Update gig basic info
            $gig->update($request->only(['title', 'type', 'description', 'photos', 'duration', 'location', 'availability', 'price']));

            // Update pricing tiers if provided
            if ($request->has('tiers')) {
                foreach ($request->tiers as $tierName => $tierData) {
                    GigTier::updateOrCreate(
                        [
                            'id_gig' => $gig->id_gig,
                            'tier_name' => strtoupper(str_replace('_', '', preg_replace('/\[|\]/', '', $tierName))),
                        ],
                        [
                            'description' => $tierData['description'] ?? '',
                            'base_price' => $tierData['base_price'] ?? 0,
                            'delivery_days' => $tierData['delivery_days'] ?? 1,
                        ]
                    );
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Gig updated successfully',
                'data' => $gig->load('tiers'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error updating gig: ' . $e->getMessage(),
            ], 500);
        }
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
