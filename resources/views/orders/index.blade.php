@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-white mb-8">My Orders</h1>

    @if($orders->isEmpty())
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-8 text-center">
            <p class="text-gray-400 mb-4">No orders yet</p>
            <a href="{{ route('services') }}" class="text-indigo-400 hover:text-indigo-300">Browse services →</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 hover:border-indigo-500 transition-all">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-semibold text-white">{{ $order->gig->title ?? 'N/A' }}</h3>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($order->status === 'completed') bg-green-500/20 text-green-400
                                    @elseif($order->status === 'confirmed') bg-blue-500/20 text-blue-400
                                    @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400
                                    @else bg-yellow-500/20 text-yellow-400
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            
                            @if(Auth::user()->isHandyman())
                                <p class="text-gray-400 text-sm">Client: {{ $order->client->fname ?? 'N/A' }} {{ $order->client->lname ?? '' }}</p>
                            @else
                                <p class="text-gray-400 text-sm">Handyman: {{ $order->handyman->user->fname ?? 'N/A' }} {{ $order->handyman->user->lname ?? '' }}</p>
                            @endif
                            
                            <p class="text-gray-500 text-sm">Order #{{ $order->order_id }}</p>
                            <p class="text-gray-500 text-sm">{{ $order->created_at->format('M d, Y') }}</p>
                            
                            @if($order->price)
                                <p class="text-white font-semibold mt-2">${{ number_format($order->price, 2) }}</p>
                            @endif
                        </div>
                        
                        <a href="{{ route('orders.show', $order->order_id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition text-sm font-semibold">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
