@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl py-12 px-6 lg:px-8">
    {{-- Back Button --}}
    <a href="{{ route('services') }}" class="inline-flex items-center text-indigo-500 hover:text-indigo-400 mb-8">
        <span class="mr-2">←</span> Back to Services
    </a>

    {{-- Main Content --}}
    <div class="bg-gray-900 rounded-lg border border-gray-800 overflow-hidden">
        {{-- Header Section --}}
        <div class="bg-gray-800 px-8 py-6 border-b border-gray-700">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $gig->title }}</h1>
                    <div class="flex items-center gap-4 flex-wrap">
                        <span class="bg-indigo-500 bg-opacity-20 text-indigo-300 text-sm font-semibold px-4 py-2 rounded-full">
                            {{ $gig->type }}
                        </span>
                        <span class="text-gray-400">Posted {{ $gig->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Rating & Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 pt-6 border-t border-gray-700">
                {{-- Average Rating --}}
                <div>
                    <p class="text-gray-400 text-sm mb-1">Average Rating</p>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($gig->average_rating))
                                    <span class="text-yellow-400">★</span>
                                @elseif ($i - $gig->average_rating < 1)
                                    <span class="text-yellow-400">☆</span>
                                @else
                                    <span class="text-gray-600">★</span>
                                @endif
                            @endfor
                        </div>
                        <span class="text-white font-semibold">{{ number_format($gig->average_rating, 1) }}</span>
                    </div>
                </div>

                {{-- Total Orders --}}
                <div>
                    <p class="text-gray-400 text-sm mb-1">Total Orders</p>
                    <p class="text-white font-semibold text-lg">{{ $gig->total_orders }}</p>
                </div>

                {{-- Handymen Available --}}
                <div>
                    <p class="text-gray-400 text-sm mb-1">Handymen Available</p>
                    <p class="text-white font-semibold text-lg">{{ $gig->total_handymen }}</p>
                </div>

                {{-- Service Type --}}
                <div>
                    <p class="text-gray-400 text-sm mb-1">Category</p>
                    <p class="text-white font-semibold">{{ $gig->type }}</p>
                </div>
            </div>
        </div>

        {{-- Description Section --}}
        <div class="px-8 py-6 border-b border-gray-700">
            <h2 class="text-2xl font-bold text-white mb-4">Description</h2>
            @if ($gig->description)
                <p class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $gig->description }}</p>
            @else
                <p class="text-gray-500 italic">No description provided</p>
            @endif
        </div>

        {{-- Handymen Section --}}
        @if ($gig->handymen->isNotEmpty())
            <div class="px-8 py-6 border-b border-gray-700">
                <h2 class="text-2xl font-bold text-white mb-6">Available Handymen</h2>
                <div class="space-y-4">
                    @foreach ($gig->handymen as $handyman)
                        <div class="bg-gray-800 rounded-lg p-4 border border-gray-700 hover:border-indigo-500 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-white font-bold text-lg">
                                        {{ $handyman->user->fname }} {{ $handyman->user->lname }}
                                    </h3>
                                    @if ($handyman->bio)
                                        <p class="text-gray-400 text-sm mt-1">{{ $handyman->bio }}</p>
                                    @endif
                                </div>
                                <form action="{{ route('conversations.start') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="handyman_id" value="{{ $handyman->handyman_id }}">
                                    <input type="hidden" name="gig_id" value="{{ $gig->id_gig }}">
                                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg transition whitespace-nowrap">Contact</button>
                                </form>
                            </div>

                            {{-- Handyman Stats --}}
                            <div class="flex items-center gap-6 text-sm pt-3 border-t border-gray-700">
                                {{-- Rating --}}
                                <div class="flex items-center gap-2">
                                    @php
                                        $orders = $handyman->orders;
                                        $ratings = $orders->filter(fn($order) => $order->rating)->pluck('rating');
                                        $avgRating = $ratings->isNotEmpty() ? $ratings->average() : 0;
                                    @endphp
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($avgRating))
                                                <span class="text-yellow-400 text-xs">★</span>
                                            @elseif ($i - $avgRating < 1)
                                                <span class="text-yellow-400 text-xs">☆</span>
                                            @else
                                                <span class="text-gray-600 text-xs">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-400">{{ number_format($avgRating, 1) }} ({{ $orders->count() }} orders)</span>
                                </div>

                                {{-- Location/Experience --}}
                                @if ($handyman->experience_years)
                                    <div class="text-gray-400">
                                        {{ $handyman->experience_years }} years experience
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="px-8 py-6 bg-gray-800 flex gap-4">
            @if($gig->handymen->isNotEmpty())
                <form action="{{ route('conversations.start') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="handyman_id" value="{{ $gig->handymen->first()->handyman_id }}">
                    <input type="hidden" name="gig_id" value="{{ $gig->id_gig }}">
                    <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 rounded-lg transition text-center">Contact a Handyman</button>
                </form>
            @else
                <div class="flex-1 bg-gray-800 text-gray-500 font-bold py-3 rounded-lg text-center">No handymen available</div>
            @endif
            <a href="{{ route('services') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition text-center">
                Back to Listings
            </a>
        </div>
    </div>
</div>
@endsection
