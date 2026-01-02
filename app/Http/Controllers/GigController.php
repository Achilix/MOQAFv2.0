<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class GigController extends Controller
{
    public function myGigs()
    {
        $user = Auth::user();
        
        if (!$user->isHandyman()) {
            abort(403, 'Only handymen can access this page.');
        }

        $gigs = $user->handyman->gigs()->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        
        return view('my-gigs', compact('gigs', 'services'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isHandyman()) {
            abort(403, 'Only handymen can create gigs.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'service_id' => 'required|exists:services,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'availability' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        // Handle photo uploads
        $photosPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('gigs', 'public');
                $photosPaths[] = $path;
            }
        }

        $gig = Gig::create([
            'title' => $validated['title'],
            'service_id' => $validated['service_id'],
            'type' => Service::find($validated['service_id'])->name,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'location' => $validated['location'] ?? null,
            'availability' => $validated['availability'] ?? null,
            'photos' => !empty($photosPaths) ? json_encode($photosPaths) : null,
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

    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user->isHandyman()) {
            abort(403, 'Only handymen can edit gigs.');
        }

        $gig = Gig::findOrFail($id);
        $services = Service::where('is_active', true)->orderBy('name')->get();
        
        // Check if this handyman owns this gig
        if (!$user->handyman->gigs()->wherePivot('id_gig', $id)->exists()) {
            abort(403, 'You can only edit your own gigs.');
        }

        return view('gigs.edit', compact('gig', 'services'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->isHandyman()) {
            abort(403, 'Only handymen can update gigs.');
        }

        $gig = Gig::findOrFail($id);
        
        // Check if this handyman owns this gig
        if (!$user->handyman->gigs()->wherePivot('id_gig', $id)->exists()) {
            abort(403, 'You can only edit your own gigs.');
        }

        $services = Service::where('is_active', true)->orderBy('name')->get();

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'service_id' => 'required|exists:services,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'availability' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|max:2048',
            'remove_photos' => 'nullable|array',
        ]);

        // Handle existing photos
        $existingPhotos = is_array($gig->photos) ? $gig->photos : ($gig->photos ? json_decode($gig->photos, true) : []);
        
        // Remove selected photos
        if ($request->has('remove_photos')) {
            foreach ($request->remove_photos as $photoToRemove) {
                if (($key = array_search($photoToRemove, $existingPhotos)) !== false) {
                    // Delete file from storage
                    \Storage::disk('public')->delete($photoToRemove);
                    unset($existingPhotos[$key]);
                }
            }
            $existingPhotos = array_values($existingPhotos);
        }

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('gigs', 'public');
                $existingPhotos[] = $path;
            }
        }

        $gig->update([
            'title' => $validated['title'],
            'service_id' => $validated['service_id'],
            'type' => Service::find($validated['service_id'])->name,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'location' => $validated['location'] ?? null,
            'availability' => $validated['availability'] ?? null,
            'photos' => !empty($existingPhotos) ? json_encode($existingPhotos) : null,
        ]);

        return redirect()->route('my-gigs')->with('success', 'Gig updated successfully!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user->isHandyman()) {
            abort(403, 'Only handymen can delete gigs.');
        }

        $gig = Gig::findOrFail($id);
        
        // Check if this handyman owns this gig
        if (!$user->handyman->gigs()->wherePivot('id_gig', $id)->exists()) {
            abort(403, 'You can only delete your own gigs.');
        }

        $gig->delete();

        return redirect()->route('my-gigs')->with('success', 'Gig deleted successfully!');
    }
}
