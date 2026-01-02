@extends('layouts.app')

@section('content')
@php
    $user = Auth::user();
    $isHandyman = $user->isHandyman();
    $isClient = $user->isClient();
    
    if ($isHandyman) {
        $handyman = $user->handyman;
        $services = is_array($handyman->services) ? $handyman->services : json_decode($handyman->services, true);
        $gigs = $handyman->gigs;
        $completedJobs = $handyman->completed_jobs_count;
        $averageRating = $handyman->average_rating;
        $recentOrders = $handyman->orders()->latest('created_at')->take(5)->get();
    }
@endphp

<div class="mx-auto max-w-7xl py-8 sm:py-12 lg:py-16">
    @if($isHandyman)
        {{-- Handyman Dashboard --}}
        <div class="space-y-8">
            {{-- Header Section --}}
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                <div class="flex items-center gap-6">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->fname }}" class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500">
                    @else
                        <div class="w-24 h-24 rounded-full bg-indigo-500 flex items-center justify-center text-white text-3xl font-bold">
                            {{ strtoupper(substr($user->fname, 0, 1)) }}{{ strtoupper(substr($user->lname, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $user->fname }} {{ $user->lname }}</h1>
                        <p class="text-gray-400 mb-3">{{ $user->address }}, {{ $user->city }}</p>
                        @if($handyman->bio)
                            <p class="text-gray-300">{{ $handyman->bio }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Stats Section --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-900 rounded-lg shadow-lg p-6 text-center">
                    <div class="text-4xl font-bold text-indigo-500 mb-2">{{ $completedJobs }}</div>
                    <p class="text-gray-400">{{ __('common.jobs_completed') }}</p>
                </div>
                <div class="bg-gray-900 rounded-lg shadow-lg p-6 text-center">
                    <div class="text-4xl font-bold text-yellow-500 mb-2">
                        {{ $averageRating ? number_format($averageRating, 1) : 'N/A' }}
                        @if($averageRating)
                            <span class="text-2xl">⭐</span>
                        @endif
                    </div>
                    <p class="text-gray-400">{{ __('common.average_rating') }}</p>
                </div>
                <div class="bg-gray-900 rounded-lg shadow-lg p-6 text-center">
                    <div class="text-4xl font-bold text-green-500 mb-2">{{ $gigs->count() }}</div>
                    <p class="text-gray-400">{{ __('common.active_gigs') }}</p>
                </div>
            </div>

            {{-- Services Section --}}
            @if($services && count($services) > 0)
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-white mb-4">{{ __('common.services_offered') }}</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($services as $service)
                        <span class="px-4 py-2 bg-indigo-500 text-white rounded-full text-sm font-medium">
                            {{ ucwords(str_replace('_', ' ', $service)) }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Gigs Section --}}
            @if($gigs->count() > 0)
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-white mb-4">{{ __('common.your_gigs') }}</h2>
                <div class="space-y-4">
                    @foreach($gigs as $gig)
                        <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $gig->title }}</h3>
                            @if($gig->description)
                                <p class="text-gray-400">{{ $gig->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Recent Orders/Jobs Chart --}}
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-white mb-4">{{ __('common.recent_jobs') }}</h2>
                @if($recentOrders->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700 flex justify-between items-center">
                                <div>
                                    <p class="text-white font-medium">Order #{{ $order->order_id }}</p>
                                    <p class="text-gray-400 text-sm">{{ $order->description }}</p>
                                    <p class="text-gray-500 text-xs mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($order->status === 'completed') bg-green-500/20 text-green-400
                                        @elseif($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                                        @else bg-blue-500/20 text-blue-400
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="text-white font-bold mt-2">${{ number_format($order->price, 2) }}</p>
                                    @if($order->rating)
                                        <p class="text-yellow-500 text-sm mt-1">⭐ {{ number_format($order->rating, 1) }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                        <p class="text-gray-400 text-center py-8">{{ __('common.no_jobs_yet') }}</p>
                @endif
            </div>

            {{-- Jobs Done Graph (Simple visualization) --}}
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-white mb-4">{{ __('common.performance_overview') }}</h2>
                <div class="h-64 flex items-end gap-4">
                    @php
                        $monthlyJobs = [];
                        for ($i = 5; $i >= 0; $i--) {
                            $date = now()->subMonths($i);
                            $count = $handyman->orders()
                                ->where('status', 'completed')
                                ->whereYear('created_at', $date->year)
                                ->whereMonth('created_at', $date->month)
                                ->count();
                            $monthlyJobs[] = ['month' => $date->format('M'), 'count' => $count];
                        }
                        $maxJobs = max(array_column($monthlyJobs, 'count')) ?: 1;
                    @endphp
                    @foreach($monthlyJobs as $data)
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-indigo-500 rounded-t-lg hover:bg-indigo-400 transition-colors" 
                                 style="height: {{ ($data['count'] / $maxJobs) * 100 }}%"
                                 title="{{ $data['count'] }} jobs">
                            </div>
                            <p class="text-gray-400 text-sm mt-2">{{ $data['month'] }}</p>
                            <p class="text-white font-bold text-xs">{{ $data['count'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($isClient)
        {{-- Client Dashboard --}}
        <div class="space-y-8">
            {{-- Header Section --}}
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                <div class="flex items-center gap-6">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->fname }}" class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500">
                    @else
                        <div class="w-24 h-24 rounded-full bg-indigo-500 flex items-center justify-center text-white text-3xl font-bold">
                            {{ strtoupper(substr($user->fname, 0, 1)) }}{{ strtoupper(substr($user->lname, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $user->fname }} {{ $user->lname }}</h1>
                        <p class="text-gray-400 mb-2">{{ $user->address }}, {{ $user->city }}</p>
                        <p class="text-gray-300">{{ __('common.welcome_client') }}</p>
                    </div>
                </div>
            </div>

            {{-- Stats Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-900 rounded-lg shadow-lg p-6 text-center">
                    <div class="text-4xl font-bold text-indigo-500 mb-2">{{ $user->client->orders->count() }}</div>
                    <p class="text-gray-400">{{ __('common.total_orders') }}</p>
                </div>
                <div class="bg-gray-900 rounded-lg shadow-lg p-6 text-center">
                    <div class="text-4xl font-bold text-green-500 mb-2">
                        {{ $user->client->orders->where('status', 'completed')->count() }}
                    </div>
                    <p class="text-gray-400">{{ __('common.completed_orders') }}</p>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-white mb-4">{{ __('common.your_recent_orders') }}</h2>
                @if($user->client->orders->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->client->orders->take(5) as $order)
                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700 flex justify-between items-center">
                                <div>
                                    <p class="text-white font-medium">Order #{{ $order->order_id }}</p>
                                    <p class="text-gray-400 text-sm">{{ $order->description }}</p>
                                    <p class="text-gray-500 text-xs mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($order->status === 'completed') bg-green-500/20 text-green-400
                                        @elseif($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                                        @else bg-blue-500/20 text-blue-400
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="text-white font-bold mt-2">${{ number_format($order->price, 2) }}</p>
                                    <a href="#" class="text-indigo-400 hover:text-indigo-300 text-sm font-semibold mt-2 inline-block">{{ __('common.view_details') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">{{ __('common.no_orders_yet') }}</p>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-white mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#" class="bg-indigo-500 hover:bg-indigo-400 rounded-lg p-6 text-center transition-colors">
                        <p class="text-white font-semibold text-lg">Post a New Task</p>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-gray-700 rounded-lg p-6 text-center transition-colors border border-gray-700">
                        <p class="text-white font-semibold text-lg">Find Handymen</p>
                    </a>
                </div>
            </div>
        </div>

    @else
        {{-- Default View if neither handyman nor client --}}
        <div class="bg-gray-900 rounded-lg shadow-lg p-8 w-full max-w-2xl mx-auto text-center">
            <h2 class="text-2xl font-bold text-white mb-2">Welcome to your Dashboard</h2>
            <p class="text-gray-400 mb-6">Complete your profile to get started!</p>
            <a href="{{ url('/') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-400">Go to Home</a>
        </div>
    @endif
</div>
@endsection
