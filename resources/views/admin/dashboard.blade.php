@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-950">
    {{-- Admin Header --}}
    <div class="bg-gray-900 border-b border-gray-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                <div class="flex items-center gap-4">
                    <span class="text-gray-400">{{ auth()->user()->fname }} {{ auth()->user()->lname }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Admin Navigation --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-8">
            <nav class="flex gap-8 overflow-x-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="text-gray-400 hover:text-white py-4 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-500 text-white' : 'border-transparent' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="text-gray-400 hover:text-white py-4 border-b-2 {{ request()->routeIs('admin.users.*') ? 'border-indigo-500 text-white' : 'border-transparent' }}">
                    Users
                </a>
                <a href="{{ route('admin.gigs.index') }}" 
                   class="text-gray-400 hover:text-white py-4 border-b-2 {{ request()->routeIs('admin.gigs.*') ? 'border-indigo-500 text-white' : 'border-transparent' }}">
                    Gigs
                </a>
                <a href="{{ route('admin.orders.index') }}" 
                   class="text-gray-400 hover:text-white py-4 border-b-2 {{ request()->routeIs('admin.orders.*') ? 'border-indigo-500 text-white' : 'border-transparent' }}">
                    Orders
                </a>
                <a href="{{ route('admin.reviews.index') }}" 
                   class="text-gray-400 hover:text-white py-4 border-b-2 {{ request()->routeIs('admin.reviews.*') ? 'border-indigo-500 text-white' : 'border-transparent' }}">
                    Reviews
                </a>
                <a href="{{ route('admin.activity-log') }}" 
                   class="text-gray-400 hover:text-white py-4 border-b-2 {{ request()->routeIs('admin.activity-log') ? 'border-indigo-500 text-white' : 'border-transparent' }}">
                    Activity Log
                </a>
                <a href="{{ route('admin.settings') }}" 
                   class="text-gray-400 hover:text-white py-4 border-b-2 {{ request()->routeIs('admin.settings') ? 'border-indigo-500 text-white' : 'border-transparent' }}">
                    Settings
                </a>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-8 py-8">
        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Users --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Users</p>
                        <p class="text-3xl font-bold text-white">{{ $total_users }}</p>
                    </div>
                    <div class="text-3xl text-indigo-500">👥</div>
                </div>
                <p class="text-gray-500 text-xs mt-4">
                    Clients: {{ $total_clients }} | Handymen: {{ $total_handymen }}
                </p>
            </div>

            {{-- Total Gigs --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Gigs</p>
                        <p class="text-3xl font-bold text-white">{{ $total_gigs }}</p>
                    </div>
                    <div class="text-3xl text-green-500">⚙️</div>
                </div>
                <a href="{{ route('admin.gigs.index') }}" class="text-indigo-500 text-xs mt-4 hover:text-indigo-400">
                    Manage Gigs →
                </a>
            </div>

            {{-- Total Orders --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Orders</p>
                        <p class="text-3xl font-bold text-white">{{ $total_orders }}</p>
                    </div>
                    <div class="text-3xl text-blue-500">📦</div>
                </div>
                <p class="text-gray-500 text-xs mt-4">
                    Pending: {{ $pending_orders }} | Completed: {{ $completed_orders }}
                </p>
            </div>

            {{-- Average Rating --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Avg Rating</p>
                        <p class="text-3xl font-bold text-white">{{ number_format($avg_rating, 2) }}/5.0</p>
                    </div>
                    <div class="text-3xl text-yellow-500">⭐</div>
                </div>
                <p class="text-gray-500 text-xs mt-4">
                    Total Reviews: {{ $total_reviews }}
                </p>
            </div>
        </div>

        {{-- Recent Data Sections --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Recent Users --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-white">Recent Users</h2>
                    <a href="{{ route('admin.users.index') }}" class="text-indigo-500 hover:text-indigo-400 text-sm">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($recent_users as $user)
                        <div class="flex justify-between items-center py-3 border-b border-gray-800">
                            <div>
                                <p class="text-white font-medium">{{ $user->fname }} {{ $user->lname }}</p>
                                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                            </div>
                            <span class="text-indigo-500 text-xs">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">No recent users</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-white">Recent Orders</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-indigo-500 hover:text-indigo-400 text-sm">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($recent_orders as $order)
                        <div class="flex justify-between items-center py-3 border-b border-gray-800">
                            <div>
                                <p class="text-white font-medium">{{ $order->gig->title ?? 'N/A' }}</p>
                                <p class="text-gray-400 text-sm">
                                    <span class="inline-block px-2 py-1 rounded text-xs"
                                          style="background-color: {{ $order->status === 'completed' ? '#10b981' : ($order->status === 'pending' ? '#f59e0b' : '#6b7280') }}; color: white;">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                            <span class="text-white font-medium">${{ $order->total_price }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">No recent orders</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Reviews --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-white">Recent Reviews</h2>
                    <a href="{{ route('admin.reviews.index') }}" class="text-indigo-500 hover:text-indigo-400 text-sm">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($recent_reviews as $review)
                        <div class="flex justify-between items-start py-3 border-b border-gray-800">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <p class="text-white font-medium">{{ $review->user->fname }} {{ $review->user->lname }}</p>
                                    <span class="text-yellow-500">{{ str_repeat('⭐', $review->rating) }}</span>
                                </div>
                                <p class="text-gray-400 text-sm">{{ substr($review->comment, 0, 100) }}...</p>
                            </div>
                            <span class="text-gray-500 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">No recent reviews</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
