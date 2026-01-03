@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-950">
    {{-- Admin Header --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">Order Management</h1>
                    <p class="text-gray-400 mt-2">Monitor and manage platform orders</p>
                </div>
                <a href="{{ route('admin.orders.export') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Export CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-8 py-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4 items-center flex-wrap">
                <input type="text" name="search" placeholder="Search by order ID or email..." 
                       value="{{ request('search') }}"
                       class="flex-1 min-w-xs bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                
                <select name="status" class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="max-w-7xl mx-auto px-8 py-8">
        @if($orders->count() > 0)
            <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-800 border-b border-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Order ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Client</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Gig</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Price</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b border-gray-800 hover:bg-gray-800 transition">
                                <td class="px-6 py-4 text-white font-mono">#{{ $order->id }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-400 text-sm">{{ $order->client->email ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4 text-white">{{ $order->gig->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                          style="background-color: {{ $order->status === 'completed' ? '#10b981' : ($order->status === 'pending' ? '#f59e0b' : '#6b7280') }}; color: white;">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-white font-medium">${{ $order->total_price }}</td>
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="text-indigo-500 hover:text-indigo-400 text-sm">View</a>
                                        <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Cancel this order?');">
                                            @csrf
                                            <button type="submit" class="text-orange-500 hover:text-orange-400 text-sm">Cancel</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-12 text-center">
                <p class="text-gray-400 text-lg">No orders found matching your filters</p>
            </div>
        @endif
    </div>
</div>
@endsection
