<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display all reviews with filtering
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'gig']);

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        // Filter by status (approved/flagged)
        if ($request->has('status')) {
            if ($request->status === 'flagged') {
                $query->where('is_flagged', true);
            } elseif ($request->status === 'approved') {
                $query->where('is_flagged', false);
            }
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%");
                  });
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show review details
     */
    public function show($id)
    {
        $review = Review::with(['user', 'gig'])->findOrFail($id);

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Flag/Unflag review
     */
    public function toggleFlag($id)
    {
        $review = Review::findOrFail($id);
        $review->is_flagged = !$review->is_flagged;
        $review->save();

        $status = $review->is_flagged ? 'flagged' : 'unflagged';

        return redirect()->back()->with('success', "Review {$status} successfully");
    }

    /**
     * Delete review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully');
    }

    /**
     * Export reviews to CSV
     */
    public function export(Request $request)
    {
        $reviews = Review::with(['user', 'gig'])->get();
        $filename = 'reviews_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($reviews) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Reviewer', 'Gig', 'Rating', 'Comment', 'Status', 'Created At']);

            foreach ($reviews as $review) {
                fputcsv($file, [
                    $review->id,
                    $review->user->email ?? 'N/A',
                    $review->gig->title ?? 'N/A',
                    $review->rating,
                    substr($review->comment, 0, 50),
                    $review->is_flagged ? 'Flagged' : 'Approved',
                    $review->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
