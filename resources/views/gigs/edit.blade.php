@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-gray-900 border border-gray-800 rounded-lg p-8">
        <h1 class="text-3xl font-bold text-white mb-6">Edit Gig</h1>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('gigs.update', $gig->id_gig) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-300 mb-2">Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $gig->title) }}"
                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="service_id" class="block text-sm font-semibold text-gray-300 mb-2">Service Type</label>
                <select id="service_id" 
                        name="service_id" 
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500"
                        required>
                    <option value="">Select a service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id', $gig->service_id) == $service->id ? 'selected' : '' }}>
                            {{ $service->icon }} {{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-300 mb-2">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="6"
                          class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500">{{ old('description', $gig->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-300 mb-2">Price ($)</label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           step="0.01"
                           value="{{ old('price', $gig->price) }}"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500"
                           placeholder="e.g., 50.00">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-semibold text-gray-300 mb-2">Duration</label>
                    <input type="text" 
                           id="duration" 
                           name="duration" 
                           value="{{ old('duration', $gig->duration) }}"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500"
                           placeholder="e.g., 2 hours">
                    @error('duration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="location" class="block text-sm font-semibold text-gray-300 mb-2">Location</label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       value="{{ old('location', $gig->location) }}"
                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500"
                       placeholder="e.g., Riyadh, Jeddah">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="availability" class="block text-sm font-semibold text-gray-300 mb-2">Availability</label>
                <textarea id="availability" 
                          name="availability" 
                          rows="3"
                          class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500"
                          placeholder="e.g., Mon-Fri 9AM-5PM">{{ old('availability', $gig->availability) }}</textarea>
                @error('availability')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pricing Tiers Management -->
            <div class="mb-6 bg-gray-800 border border-gray-700 rounded-lg p-6">
                <h2 class="text-xl font-bold text-white mb-4">Pricing Tiers</h2>
                <p class="text-gray-400 text-sm mb-4">Set up three pricing options for your gig: BASIC (small jobs), MEDIUM (medium-sized work), and PREMIUM (large projects)</p>
                
                @php
                    $tiers = $gig->tiers->keyBy('tier_name') ?? collect();
                @endphp

                <div class="space-y-6">
                    @foreach(['BASIC', 'MEDIUM', 'PREMIUM'] as $tierName)
                        @php
                            $tier = $tiers->get($tierName);
                        @endphp
                        <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">
                            <div class="flex items-center mb-4">
                                <span class="text-lg font-semibold text-white">{{ $tierName }}</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-400 mb-2">Description</label>
                                    <textarea name="tiers[{{ $tierName }}][description]" 
                                              rows="2"
                                              class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded text-white text-sm focus:outline-none focus:border-indigo-500"
                                              placeholder="What's included in this tier?">{{ old('tiers.' . $tierName . '.description', $tier?->description ?? '') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-400 mb-2">Price ($)</label>
                                    <input type="number" 
                                           name="tiers[{{ $tierName }}][base_price]" 
                                           step="0.01"
                                           min="0.01"
                                           value="{{ old('tiers.' . $tierName . '.base_price', $tier?->base_price ?? '') }}"
                                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded text-white text-sm focus:outline-none focus:border-indigo-500"
                                           placeholder="e.g., 50.00"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-400 mb-2">Delivery Days</label>
                                    <input type="number" 
                                           name="tiers[{{ $tierName }}][delivery_days]" 
                                           min="1"
                                           max="30"
                                           value="{{ old('tiers.' . $tierName . '.delivery_days', $tier?->delivery_days ?? '') }}"
                                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded text-white text-sm focus:outline-none focus:border-indigo-500"
                                           placeholder="e.g., 3"
                                           required>
                                </div>
                            </div>

                            @if($tier)
                                <div class="mt-3 text-xs text-gray-500">
                                    Last updated: {{ $tier->updated_at->diffForHumans() }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <p class="text-gray-500 text-xs mt-4">All three tiers are required. Customers will see all pricing options when viewing your gig.</p>
            </div>

            <!-- Existing Photos -->
            @if($gig->photos)
                @php
                    $photos = is_array($gig->photos) ? $gig->photos : json_decode($gig->photos, true) ?? [];
                @endphp
                @if(!empty($photos))
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Current Photos</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($photos as $photo)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Gig photo" class="w-full h-32 object-cover rounded-lg">
                                    <label class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded-full cursor-pointer">
                                        <input type="checkbox" name="remove_photos[]" value="{{ $photo }}" class="hidden">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-gray-400 text-sm mt-2">Check the X to remove photos</p>
                    </div>
                @endif
            @endif

            <!-- Add New Photos -->
            <div class="mb-6">
                <label for="photos" class="block text-sm font-semibold text-gray-300 mb-2">Add New Photos</label>
                <input type="file" 
                       id="photos" 
                       name="photos[]" 
                       multiple 
                       accept="image/*"
                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-indigo-500">
                <p class="text-gray-400 text-sm mt-2">Max 2MB per image</p>
                @error('photos')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 rounded-lg transition">
                    Update Gig
                </button>
                <a href="{{ route('my-gigs') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition text-center">
                    Cancel
                </a>
            </div>
        </form>

        <form action="{{ route('gigs.destroy', $gig->id_gig) }}" method="POST" class="mt-6" onsubmit="return confirm('Are you sure you want to delete this gig?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition">
                Delete Gig
            </button>
        </form>
    </div>
</div>
@endsection
