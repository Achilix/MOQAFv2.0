<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Gig;
use App\Models\Handyman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Get all favorites for the authenticated user.
     */
    public function index(Request $request)
    {
        $query = Favorite::where('user_id', Auth::id())->recent();

        // Filter by type
        if ($request->has('type')) {
            $query->ofType($request->type);
        }

        $favorites = $query->paginate(20);

        // Load the actual favoritable items
        $favorites->getCollection()->transform(function ($favorite) {
            if ($favorite->favoritable_type === 'App\\Models\\Gig') {
                $favorite->item = Gig::with('handymen')->find($favorite->favoritable_id);
            } elseif ($favorite->favoritable_type === 'App\\Models\\Handyman') {
                $favorite->item = Handyman::find($favorite->favoritable_id);
            }
            return $favorite;
        });

        return response()->json([
            'favorites' => $favorites,
        ]);
    }

    /**
     * Add an item to favorites.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:gig,handyman',
            'id' => 'required|integer',
        ]);

        $type = $validated['type'] === 'gig' ? 'App\\Models\\Gig' : 'App\\Models\\Handyman';
        $id = $validated['id'];

        // Check if item exists
        if ($type === 'App\\Models\\Gig') {
            if (!Gig::where('id_gig', $id)->exists()) {
                return response()->json([
                    'message' => 'Gig not found.',
                ], 404);
            }
        } else {
            if (!Handyman::where('handyman_id', $id)->exists()) {
                return response()->json([
                    'message' => 'Handyman not found.',
                ], 404);
            }
        }

        // Check if already favorited
        $existing = Favorite::where('user_id', Auth::id())
            ->where('favoritable_type', $type)
            ->where('favoritable_id', $id)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Item already in favorites.',
            ], 400);
        }

        $favorite = Favorite::create([
            'user_id' => Auth::id(),
            'favoritable_type' => $type,
            'favoritable_id' => $id,
        ]);

        return response()->json([
            'message' => 'Item added to favorites.',
            'favorite' => $favorite,
        ], 201);
    }

    /**
     * Remove an item from favorites.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:gig,handyman',
            'id' => 'required|integer',
        ]);

        $type = $validated['type'] === 'gig' ? 'App\\Models\\Gig' : 'App\\Models\\Handyman';
        $id = $validated['id'];

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('favoritable_type', $type)
            ->where('favoritable_id', $id)
            ->first();

        if (!$favorite) {
            return response()->json([
                'message' => 'Item not in favorites.',
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Item removed from favorites.',
        ]);
    }

    /**
     * Check if an item is favorited.
     */
    public function check(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:gig,handyman',
            'id' => 'required|integer',
        ]);

        $type = $validated['type'] === 'gig' ? 'App\\Models\\Gig' : 'App\\Models\\Handyman';
        $id = $validated['id'];

        $isFavorited = Favorite::where('user_id', Auth::id())
            ->where('favoritable_type', $type)
            ->where('favoritable_id', $id)
            ->exists();

        return response()->json([
            'is_favorited' => $isFavorited,
        ]);
    }
}
