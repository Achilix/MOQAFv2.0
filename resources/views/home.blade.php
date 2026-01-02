@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl py-12 px-6 lg:px-8">
    @php
        $searchAction = auth()->check() ? route('home') : route('services');
    @endphp
    {{-- Hero Section --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">{{ __('common.discover_services') }}</h1>
        <p class="text-gray-400 text-lg">{{ __('common.find_trusted_handymen') }}</p>
    </div>

    {{-- Search Bar --}}
    <div class="mb-8">
        <form action="{{ $searchAction }}" method="GET" class="space-y-4">
            {{-- Search Input --}}
            <div class="flex gap-4">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="{{ __('common.search_placeholder_simple') }}" 
                    class="flex-1 bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:border-indigo-500"
                >
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-3 px-8 rounded-lg transition">
                    {{ __('common.search') }}
                </button>
                @if ($search || $serviceType)
                    <a href="{{ $searchAction }}" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-lg transition">
                        {{ __('common.clear_all') }}
                    </a>
                @endif
            </div>

            {{-- Filters Row --}}
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                {{-- Service Type Filter --}}
                <div class="w-full sm:w-auto">
                    <label for="service_type" class="text-gray-400 font-semibold block sm:inline-block sm:mr-3 mb-2 sm:mb-0">{{ __('common.service_type') }}:</label>
                    <select 
                        name="service_type" 
                        id="service_type" 
                        class="w-full sm:w-auto bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500"
                        onchange="this.form.submit()"
                    >
                        <option value="">{{ __('common.all_services') }}</option>
                        @foreach ($serviceTypes as $type)
                            <option value="{{ $type }}" {{ $serviceType === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort Filter --}}
                <div class="w-full sm:w-auto sm:ml-auto">
                    <label for="sort" class="text-gray-400 font-semibold block sm:inline-block sm:mr-3 mb-2 sm:mb-0">{{ __('common.sort_by') }}:</label>
                    <select 
                        name="sort" 
                        id="sort" 
                        class="w-full sm:w-auto bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500"
                        onchange="this.form.submit()"
                    >
                        <option value="rating" {{ $sortBy === 'rating' ? 'selected' : '' }}>{{ __('common.highest_rated') }}</option>
                        <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>{{ __('common.newest_first') }}</option>
                        <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>{{ __('common.oldest_first') }}</option>
                        <option value="type" {{ $sortBy === 'type' ? 'selected' : '' }}>{{ __('common.service_type_az') }}</option>
                        <option value="title" {{ $sortBy === 'title' ? 'selected' : '' }}>{{ __('common.title_az') }}</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    {{-- Results Info --}}
    @if ($search)
        <div class="mb-6 text-gray-400">
            Found <span class="text-white font-semibold">{{ $gigs->count() }}</span> results for "<span class="text-white font-semibold">{{ $search }}</span>"
        </div>
    @endif

    {{-- Gigs Grid --}}
    @if ($gigs->isEmpty())
        <div class="bg-gray-900 rounded-lg p-12 border border-gray-800 text-center">
            @if ($search)
                <p class="text-gray-400 text-lg">{{ __('common.no_services_found') }}</p>
                <a href="{{ $searchAction }}" class="mt-4 inline-block text-indigo-500 hover:text-indigo-400">{{ __('common.clear') }}</a>
            @else
                <p class="text-gray-400 text-lg">{{ __('common.no_services_available') }}</p>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($gigs as $gig)
                <div class="bg-gray-900 rounded-lg border border-gray-800 overflow-hidden hover:border-indigo-500 transition">
                    {{-- Service Type Badge --}}
                    <div class="bg-gray-800 px-4 py-2">
                        <span class="bg-indigo-500 bg-opacity-20 text-indigo-300 text-xs font-semibold px-3 py-1 rounded-full inline-block">
                            {{ $gig->type }}
                        </span>
                    </div>

                    {{-- Card Content --}}
                    <div class="p-6">
                        {{-- Title --}}
                        <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $gig->title }}</h3>

                        {{-- Description --}}
                        @if ($gig->description)
                            <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ $gig->description }}</p>
                        @else
                            <p class="text-gray-500 text-sm mb-4 italic">No description provided</p>
                        @endif

                        {{-- Rating & Stats --}}
                        <div class="flex items-center gap-4 mb-4 py-4 border-t border-gray-800">
                            {{-- Rating --}}
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
                                <span class="text-gray-400 text-sm">
                                    {{ number_format($gig->average_rating, 1) }}
                                    @if ($gig->total_orders > 0)
                                        <span class="text-gray-500">({{ $gig->total_orders }})</span>
                                    @else
                                        <span class="text-gray-500">(New)</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Date --}}
                        <div class="text-gray-500 text-sm mb-4 border-b border-gray-800 pb-4">
                            {{ __('common.posted') }} {{ $gig->created_at->diffForHumans() }}
                        </div>

                        {{-- Action Button --}}
                        <a href="{{ route('gigs.show', $gig->id_gig) }}" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 rounded-lg transition block text-center">
                            {{ __('common.view_service') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
