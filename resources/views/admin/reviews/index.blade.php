@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-950">
    {{-- Admin Header --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">Review Management</h1>
                    <p class="text-gray-400 mt-2">Moderate and manage user reviews</p>
                </div>
                <a href="{{ route('admin.reviews.export') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Export CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-8 py-4">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex gap-4 items-center flex-wrap">
                <input type="text" name="search" placeholder="Search reviews..." 
                       value="{{ request('search') }}"
                       class="flex-1 min-w-xs bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                
                <select name="rating" class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>1 Star</option>
                </select>

                <select name="status" class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="flagged" {{ request('status') === 'flagged' ? 'selected' : '' }}>Flagged</option>
                </select>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- Reviews --}}
    <div class="max-w-7xl mx-auto px-8 py-8">
        @if($reviews->count() > 0)
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 hover:border-gray-700 transition">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <p class="text-white font-medium">{{ $review->user->fname }} {{ $review->user->lname }}</p>
                                    <div class="flex gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-yellow-400">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-400 text-sm">For: {{ $review->gig->title ?? 'N/A' }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                  style="background-color: {{ $review->is_flagged ? '#ef4444' : '#10b981' }}; color: white;">
                                {{ $review->is_flagged ? 'Flagged' : 'Approved' }}
                            </span>
                        </div>

                        <p class="text-gray-300 mb-4 leading-relaxed">{{ $review->comment }}</p>

                        <div class="flex justify-between items-center">
                            <p class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</p>
                            <div class="flex items-center gap-3">
                                <form action="{{ route('admin.reviews.toggle-flag', $review->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-amber-500 px-3 py-1.5 text-sm font-semibold text-black hover:bg-amber-400 transition">
                                        {{ $review->is_flagged ? 'Unflag' : 'Flag' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Delete this review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-500 transition">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-12 text-center">
                <p class="text-gray-400 text-lg">No reviews found matching your filters</p>
            </div>
        @endif
    </div>
</div>
@endsection
