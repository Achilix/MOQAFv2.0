<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Gig;
use App\Models\Order;
use App\Models\Review;
use App\Models\Handyman;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with platform statistics
     */
    public function index()
    {
        $total_users = User::count();
        $total_clients = Client::count();
        $total_handymen = Handyman::count();
        $total_gigs = Gig::count();
        $total_orders = Order::count();
        $total_reviews = Review::count();
        $pending_orders = Order::where('status', 'pending')->count();
        $completed_orders = Order::where('status', 'completed')->count();
        $avg_rating = Review::avg('rating') ?? 0;
        $recent_users = User::latest()->take(5)->get();
        $recent_orders = Order::with(['client', 'gig'])->latest()->take(5)->get();
        $recent_reviews = Review::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'total_users',
            'total_clients',
            'total_handymen',
            'total_gigs',
            'total_orders',
            'total_reviews',
            'pending_orders',
            'completed_orders',
            'avg_rating',
            'recent_users',
            'recent_orders',
            'recent_reviews'
        ));
    }

    /**
     * Show admin activity log
     */
    public function activityLog()
    {
        return view('admin.activity-log');
    }

    /**
     * Show admin settings
     */
    public function settings()
    {
        return view('admin.settings');
    }
}
