<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sortBy = $request->input('sort', 'rating'); // Default sort by rating
        $serviceType = $request->input('service_type', ''); // Filter by service type
        
        $query = Gig::with(['handymen' => function ($q) {
            $q->with('orders');
        }]);

        // Apply search filter
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
        }

        // Apply service type filter
        if ($serviceType) {
            $query->where('type', $serviceType);
        }

        // Get all gigs
        $allGigs = $query->get();

        // Calculate rating and prepare for sorting
        $gigs = $allGigs->map(function ($gig) {
            // Calculate average rating from orders
            $orders = $gig->handymen->flatMap->orders;
            $ratings = $orders->filter(fn($order) => $order->rating)->pluck('rating');
            
            $gig->average_rating = $ratings->isNotEmpty() ? $ratings->average() : 0;
            $gig->total_orders = $orders->count();
            
            return $gig;
        });

        // Apply sorting based on selected option
        if ($sortBy === 'rating') {
            $gigs = $gigs->sortBy([
                [fn($a, $b) => $b['average_rating'] <=> $a['average_rating']],
                [fn($a, $b) => $b->created_at <=> $a->created_at]
            ])->values();
        } elseif ($sortBy === 'newest') {
            $gigs = $gigs->sortBy(fn($a, $b) => $b->created_at <=> $a->created_at)->values();
        } elseif ($sortBy === 'oldest') {
            $gigs = $gigs->sortBy(fn($a, $b) => $a->created_at <=> $b->created_at)->values();
        } elseif ($sortBy === 'type') {
            $gigs = $gigs->sortBy('type')->values();
        } elseif ($sortBy === 'title') {
            $gigs = $gigs->sortBy('title')->values();
        }

        // Get all unique service types for filter dropdown
        $serviceTypes = Gig::select('type')->distinct()->orderBy('type')->pluck('type')->toArray();

        return view('home', compact('gigs', 'search', 'sortBy', 'serviceType', 'serviceTypes'));
    }
}
