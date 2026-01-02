<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isHandyman()) {
            // Get orders for this handyman
            $orders = Order::where('id_handyman', $user->handyman->handyman_id)
                ->with(['client', 'gig'])
                ->orderByDesc('created_at')
                ->get();
        } else {
            // Get orders for this client
            $orders = Order::where('id_client', $user->client->client_id)
                ->with(['handyman.user', 'gig'])
                ->orderByDesc('created_at')
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $order = Order::with(['client', 'handyman.user', 'gig'])->findOrFail($id);

        // Check authorization
        if ($user->isHandyman()) {
            if ($order->id_handyman !== $user->handyman->handyman_id) {
                abort(403, 'Unauthorized access to this order.');
            }
        } else {
            if ($order->id_client !== $user->client->client_id) {
                abort(403, 'Unauthorized access to this order.');
            }
        }

        return view('orders.show', compact('order'));
    }
}
