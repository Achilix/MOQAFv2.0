@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6">
        <a href="{{ route('my-orders') }}" class="text-indigo-400 hover:text-indigo-300">← Back to Orders</a>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-800">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-white">Order #{{ $order->order_id }}</h1>
                <span class="px-4 py-2 text-sm font-semibold rounded-full
                    @if($order->status === 'completed') bg-green-500/20 text-green-400
                    @elseif($order->status === 'confirmed') bg-blue-500/20 text-blue-400
                    @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400
                    @else bg-yellow-500/20 text-yellow-400
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="px-8 py-6 space-y-6">
            <!-- Gig Details -->
            <div>
                <h2 class="text-lg font-semibold text-white mb-3">Service</h2>
                <div class="bg-gray-800 rounded-lg p-4">
                    <h3 class="text-white font-semibold">{{ $order->gig->title ?? 'N/A' }}</h3>
                    <p class="text-gray-400 text-sm mt-1">{{ $order->gig->type ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Client/Handyman Info -->
            <div>
                <h2 class="text-lg font-semibold text-white mb-3">
                    @if(Auth::user()->isHandyman())
                        Client Information
                    @else
                        Handyman Information
                    @endif
                </h2>
                <div class="bg-gray-800 rounded-lg p-4">
                    @if(Auth::user()->isHandyman())
                        <p class="text-white font-semibold">{{ $order->client->fname ?? 'N/A' }} {{ $order->client->lname ?? '' }}</p>
                        <p class="text-gray-400 text-sm">{{ $order->client->phone_number ?? 'No phone' }}</p>
                    @else
                        <p class="text-white font-semibold">{{ $order->handyman->user->fname ?? 'N/A' }} {{ $order->handyman->user->lname ?? '' }}</p>
                        <p class="text-gray-400 text-sm">{{ $order->handyman->user->phone_number ?? 'No phone' }}</p>
                    @endif
                </div>
            </div>

            <!-- Order Details -->
            <div>
                <h2 class="text-lg font-semibold text-white mb-3">Order Details</h2>
                <div class="bg-gray-800 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Order Date:</span>
                        <span class="text-white">{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    @if($order->price)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Price:</span>
                            <span class="text-white font-semibold">${{ number_format($order->price, 2) }}</span>
                        </div>
                    @endif
                    @if($order->rating)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Rating:</span>
                            <span class="text-yellow-400">{{ $order->rating }} ⭐</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
