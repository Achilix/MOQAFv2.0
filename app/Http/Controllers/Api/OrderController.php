<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::where('client_id', $user->id)
            ->orWhere('handyman_id', $user->handyman->handyman_id ?? null)
            ->with(['client', 'handyman', 'gig'])
            ->paginate(15);

        return response()->json([
            'data' => $orders->items(),
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ],
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = Order::with(['client', 'handyman', 'gig'])->findOrFail($id);

        $user = $request->user();
        if ($order->client_id !== $user->id && $order->handyman_id !== $user->handyman?->handyman_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $order]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gig_id' => 'required|exists:gigs,id_gig',
            'handyman_id' => 'required|exists:handyman,handyman_id',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $order = Order::create([
            'client_id' => $request->user()->id,
            'gig_id' => $validated['gig_id'],
            'handyman_id' => $validated['handyman_id'],
            'budget' => $validated['budget'],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order->load(['client', 'handyman', 'gig']),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->client_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'budget' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order,
        ]);
    }

    public function accept(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->handyman_id !== $request->user()->handyman?->handyman_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Order cannot be accepted in this status'], 400);
        }

        $order->update(['status' => 'accepted']);

        return response()->json([
            'message' => 'Order accepted successfully',
            'data' => $order,
        ]);
    }

    public function reject(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->handyman_id !== $request->user()->handyman?->handyman_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Order rejected',
            'data' => $order,
        ]);
    }

    public function complete(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->handyman_id !== $request->user()->handyman?->handyman_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->status !== 'accepted') {
            return response()->json(['message' => 'Order cannot be completed in this status'], 400);
        }

        $order->update(['status' => 'completed']);

        return response()->json([
            'message' => 'Order completed successfully',
            'data' => $order,
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->client_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!in_array($order->status, ['pending', 'accepted'])) {
            return response()->json(['message' => 'Order cannot be cancelled in this status'], 400);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Order cancelled successfully',
            'data' => $order,
        ]);
    }
}
