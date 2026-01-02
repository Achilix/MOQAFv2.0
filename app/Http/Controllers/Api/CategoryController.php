<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Get all categories (tree structure).
     */
    public function index()
    {
        $categories = Category::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    /**
     * Get a single category with its gigs.
     */
    public function show($id)
    {
        $category = Category::with(['children', 'parent'])
            ->findOrFail($id);

        $gigs = $category->gigs()
            ->with(['handymen'])
            ->paginate(20);

        return response()->json([
            'category' => $category,
            'gigs' => $gigs,
        ]);
    }

    /**
     * Create a new category (admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:categories,category_id',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully.',
            'category' => $category,
        ], 201);
    }

    /**
     * Update a category (admin only).
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:100|unique:categories,name,' . $id . ',category_id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:categories,category_id',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Prevent category from being its own parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $category->category_id) {
            return response()->json([
                'message' => 'A category cannot be its own parent.',
            ], 400);
        }

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully.',
            'category' => $category->fresh(),
        ]);
    }

    /**
     * Delete a category (admin only).
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if category has children
        if ($category->children()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete category with subcategories. Please delete subcategories first.',
            ], 400);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }

    /**
     * Get popular categories based on gig count.
     */
    public function popular()
    {
        $categories = Category::active()
            ->withCount('gigs')
            ->having('gigs_count', '>', 0)
            ->orderBy('gigs_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }
}
