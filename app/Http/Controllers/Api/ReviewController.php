<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Get all reviews for a handyman.
     */
    public function getHandymanReviews($handyman_id)
    {
        $reviews = Review::where('handyman_id', $handyman_id)
            ->with(['client:id,fname,lname,photo'])
            ->recent()
            ->paginate(20);

        $avgRating = Review::where('handyman_id', $handyman_id)->avg('rating');
        $totalReviews = Review::where('handyman_id', $handyman_id)->count();

        return response()->json([
            'reviews' => $reviews,
            'statistics' => [
                'average_rating' => round($avgRating, 2),
                'total_reviews' => $totalReviews,
            ],
        ]);
    }

    /**
     * Create a review for an order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        // Check if user is the client of this order
        if ($order->client_id !== Auth::id()) {
            return response()->json([
                'message' => 'You can only review orders you created.',
            ], 403);
        }

        // Check if order is completed
        if ($order->status !== 'completed') {
            return response()->json([
                'message' => 'You can only review completed orders.',
            ], 400);
        }

        // Check if already reviewed
        $existingReview = Review::where('order_id', $order->order_id)->first();
        if ($existingReview) {
            return response()->json([
                'message' => 'You have already reviewed this order.',
            ], 400);
        }

        $review = Review::create([
            'order_id' => $order->order_id,
            'client_id' => Auth::id(),
            'handyman_id' => $order->handyman_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'Review submitted successfully.',
            'review' => $review->load(['client:id,fname,lname,photo']),
        ], 201);
    }

    /**
     * Add a response to a review (handyman only).
     */
    public function respond(Request $request, $review_id)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($review_id);

        // Get current user's handyman profile
        $user = Auth::user();
        $handyman = $user->handyman;

        if (!$handyman) {
            return response()->json([
                'message' => 'Only handymen can respond to reviews.',
            ], 403);
        }

        // Check if review is for this handyman
        if ($review->handyman_id !== $handyman->handyman_id) {
            return response()->json([
                'message' => 'You can only respond to your own reviews.',
            ], 403);
        }

        $review->update([
            'response' => $validated['response'],
            'response_at' => now(),
        ]);

        return response()->json([
            'message' => 'Response added successfully.',
            'review' => $review,
        ]);
    }

    /**
     * Update a review (client only, within 24 hours).
     */
    public function update(Request $request, $review_id)
    {
        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::findOrFail($review_id);

        // Check if user is the review author
        if ($review->client_id !== Auth::id()) {
            return response()->json([
                'message' => 'You can only update your own reviews.',
            ], 403);
        }

        // Check if within 24 hours
        if ($review->created_at->diffInHours(now()) > 24) {
            return response()->json([
                'message' => 'Reviews can only be edited within 24 hours of posting.',
            ], 400);
        }

        $review->update($validated);

        return response()->json([
            'message' => 'Review updated successfully.',
            'review' => $review,
        ]);
    }

    /**
     * Delete a review (client only, within 24 hours).
     */
    public function destroy($review_id)
    {
        $review = Review::findOrFail($review_id);

        // Check if user is the review author
        if ($review->client_id !== Auth::id()) {
            return response()->json([
                'message' => 'You can only delete your own reviews.',
            ], 403);
        }

        // Check if within 24 hours
        if ($review->created_at->diffInHours(now()) > 24) {
            return response()->json([
                'message' => 'Reviews can only be deleted within 24 hours of posting.',
            ], 400);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully.',
        ]);
    }
}
