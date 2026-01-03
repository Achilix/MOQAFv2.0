@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-950">
    {{-- Admin Header --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">Gig Management</h1>
                    <p class="text-gray-400 mt-2">Manage handyman services and pricing tiers</p>
                </div>
                <a href="{{ route('admin.gigs.export') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Export CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-8 py-4">
            <form action="{{ route('admin.gigs.index') }}" method="GET" class="flex gap-4 items-center">
                <input type="text" name="search" placeholder="Search by title or description..." 
                       value="{{ request('search') }}"
                       class="flex-1 bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                
                <select name="type" class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                    <option value="">All Types</option>
                    <option value="plumbing" {{ request('type') === 'plumbing' ? 'selected' : '' }}>Plumbing</option>
                    <option value="electrical" {{ request('type') === 'electrical' ? 'selected' : '' }}>Electrical</option>
                    <option value="carpentry" {{ request('type') === 'carpentry' ? 'selected' : '' }}>Carpentry</option>
                    <option value="painting" {{ request('type') === 'painting' ? 'selected' : '' }}>Painting</option>
                </select>

                <select name="status" class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700 focus:border-indigo-500 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- Gigs Table --}}
    <div class="max-w-7xl mx-auto px-8 py-8">
        @if($gigs->count() > 0)
            <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-800 border-b border-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Title</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Type</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Handyman</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Tiers</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Created</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gigs as $gig)
                            <tr class="border-b border-gray-800 hover:bg-gray-800 transition">
                                <td class="px-6 py-4">
                                    <p class="text-white font-medium">{{ $gig->title }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-400">{{ ucfirst($gig->type) }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-400 text-sm">
                                        {{ $gig->handymen->pluck('name')->implode(', ') ?: 'Unassigned' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300">
                                        {{ $gig->tiers->count() }} tiers
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                          style="background-color: {{ $gig->is_active ? '#10b981' : '#ef4444' }}; color: white;">
                                        {{ $gig->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $gig->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.gigs.show', $gig->id_gig) }}"
                                           class="inline-flex items-center justify-center rounded-md border border-gray-700 px-3 py-1.5 text-sm font-semibold text-white hover:border-indigo-500 hover:text-indigo-200 transition">
                                            View
                                        </a>
                                        <a href="{{ route('admin.gigs.edit', $gig->id_gig) }}"
                                           class="inline-flex items-center justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-400 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.gigs.destroy', $gig->id_gig) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-500 transition">
                                                Delete
                                            </button>
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
                {{ $gigs->links() }}
            </div>
        @else
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-12 text-center">
                <p class="text-gray-400 text-lg">No gigs found matching your filters</p>
            </div>
        @endif
    </div>
</div>
@endsection
