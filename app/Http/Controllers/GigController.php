<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GigController extends Controller
{
    public function myGigs()
    {
        $user = Auth::user();
        
        if (!$user->isHandyman()) {
            abort(403, 'Only handymen can access this page.');
        }

        $gigs = $user->handyman->gigs()->get();
        
        return view('my-gigs', compact('gigs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isHandyman()) {
            abort(403, 'Only handymen can create gigs.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $gig = Gig::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'photos' => null,
        ]);

        $user->handyman->gigs()->attach($gig->id_gig);

        return redirect()->route('my-gigs')->with('success', 'Gig created successfully!');
    }

    public function show($id)
    {
        $gig = Gig::with(['handymen' => function ($q) {
            $q->with('orders');
        }])->findOrFail($id);

        // Calculate rating and stats
        $orders = $gig->handymen->flatMap->orders;
        $ratings = $orders->filter(fn($order) => $order->rating)->pluck('rating');
        
        $gig->average_rating = $ratings->isNotEmpty() ? $ratings->average() : 0;
        $gig->total_orders = $orders->count();
        $gig->total_handymen = $gig->handymen->count();

        return view('gig-detail', compact('gig'));
    }
}
