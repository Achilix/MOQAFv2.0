<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gig;
use App\Models\GigTier;
use Illuminate\Http\Request;

class GigController extends Controller
{
    /**
     * Display all gigs with filtering
     */
    public function index(Request $request)
    {
        $query = Gig::with(['handymen', 'tiers']);

        // Filter by search
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }

        // Filter by type/category
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $gigs = $query->paginate(20);

        return view('admin.gigs.index', compact('gigs'));
    }

    /**
     * Show gig details
     */
    public function show($id)
    {
        $gig = Gig::with(['handymen', 'tiers'])->findOrFail($id);

        return view('admin.gigs.show', compact('gig'));
    }

    /**
     * Edit gig
     */
    public function edit($id)
    {
        $gig = Gig::with('tiers')->findOrFail($id);

        return view('admin.gigs.edit', compact('gig'));
    }

    /**
     * Update gig
     */
    public function update(Request $request, $id)
    {
        $gig = Gig::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $gig->update($validated);

        return redirect()->route('admin.gigs.show', $id)
                       ->with('success', 'Gig updated successfully');
    }

    /**
     * Delete gig
     */
    public function destroy($id)
    {
        $gig = Gig::findOrFail($id);
        $gig->delete();

        return redirect()->route('admin.gigs.index')
                       ->with('success', 'Gig deleted successfully');
    }

    /**
     * Toggle gig active/inactive status
     */
    public function toggleStatus($id)
    {
        $gig = Gig::findOrFail($id);
        $gig->is_active = !$gig->is_active;
        $gig->save();

        $status = $gig->is_active ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Gig {$status} successfully");
    }

    /**
     * Export gigs to CSV
     */
    public function export()
    {
        $gigs = Gig::with(['handymen', 'tiers'])->get();
        $filename = 'gigs_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($gigs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Title', 'Type', 'Handyman', 'Tiers Count', 'Status', 'Created At']);

            foreach ($gigs as $gig) {
                fputcsv($file, [
                    $gig->id_gig,
                    $gig->title,
                    $gig->type,
                    $gig->handymen->pluck('name')->implode(', ') ?: 'N/A',
                    $gig->tiers->count(),
                    $gig->is_active ? 'Active' : 'Inactive',
                    $gig->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
