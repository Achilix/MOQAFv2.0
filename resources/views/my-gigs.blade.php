@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black pt-20 px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2">{{ __('common.my_gigs') }}</h1>
                <p class="text-gray-400">{{ __('common.manage_gigs_subtitle') }}</p>
            </div>
            <button onclick="toggleForm()" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg transition">
                {{ __('common.add_gig') }}
            </button>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-500 bg-opacity-10 border border-green-500 text-green-300 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Add Gig Form (Hidden by default) --}}
        <div id="formContainer" class="bg-gray-900 rounded-lg p-8 mb-8 border border-gray-800 hidden">
            <h2 class="text-2xl font-bold text-white mb-6">{{ __('common.create_gig') }}</h2>
            
            <form action="{{ route('gigs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div class="mb-6">
                    <label for="title" class="block text-white font-semibold mb-2">{{ __('common.gig_title') }}</label>
                    <input type="text" id="title" name="title" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500" placeholder="{{ __('common.gig_title_placeholder') }}" required>
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="mb-6">
                    <label for="type" class="block text-white font-semibold mb-2">{{ __('common.service_type') }}</label>
                    <select id="type" name="type" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500" required>
                        <option value="">{{ __('common.select_service_type') }}</option>
                        <option value="Plumbing">{{ __('common.service_plumbing') }}</option>
                        <option value="Electrical">{{ __('common.service_electrical') }}</option>
                        <option value="Carpentry">{{ __('common.service_carpentry') }}</option>
                        <option value="Painting">{{ __('common.service_painting') }}</option>
                        <option value="Cleaning">{{ __('common.service_cleaning') }}</option>
                        <option value="HVAC">{{ __('common.service_hvac') }}</option>
                        <option value="Landscaping">{{ __('common.service_landscaping') }}</option>
                        <option value="Roofing">{{ __('common.service_roofing') }}</option>
                        <option value="Appliance Repair">{{ __('common.service_appliance_repair') }}</option>
                        <option value="Other">{{ __('common.service_other') }}</option>
                    </select>
                    @error('type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <label for="description" class="block text-white font-semibold mb-2">{{ __('common.description') }}</label>
                    <textarea id="description" name="description" rows="4" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500" placeholder="{{ __('common.gig_description_placeholder') }}"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Photos --}}
                <div class="mb-6">
                    <label for="photos" class="block text-white font-semibold mb-2">{{ __('common.photos_optional') }}</label>
                    <input type="file" id="photos" name="photos[]" multiple accept="image/*" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                    <p class="text-gray-400 text-sm mt-2">{{ __('common.upload_limit') }}</p>
                    @error('photos')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4">
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg transition">
                        {{ __('common.create_gig_btn') }}
                    </button>
                    <button type="button" onclick="toggleForm()" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition">
                        {{ __('common.cancel') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Gigs List --}}
        @if ($gigs->isEmpty())
            <div class="bg-gray-900 rounded-lg p-12 border border-gray-800 text-center">
                <p class="text-gray-400 text-lg">{{ __('common.no_gigs_created') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($gigs as $gig)
                    <div class="bg-gray-900 rounded-lg p-6 border border-gray-800 hover:border-indigo-500 transition">
                        {{-- Gig Header --}}
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-white">{{ $gig->title }}</h3>
                            <span class="bg-indigo-500 bg-opacity-20 text-indigo-300 text-xs font-semibold px-3 py-1 rounded-full">{{ $gig->type }}</span>
                        </div>
                        
                        {{-- Description --}}
                        @if ($gig->description)
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $gig->description }}</p>
                        @else
                            <p class="text-gray-500 text-sm mb-4 italic">{{ __('common.no_description') }}</p>
                        @endif

                        {{-- Created Date --}}
                        <div class="flex justify-between items-center pt-4 border-t border-gray-800">
                            <span class="text-gray-500 text-sm">
                                {{ __('common.created_label') }} {{ $gig->created_at->diffForHumans() }}
                            </span>
                            <div class="flex gap-2">
                                <button class="text-indigo-500 hover:text-indigo-400 font-semibold text-sm">
                                    {{ __('common.edit') }}
                                </button>
                                <button class="text-red-500 hover:text-red-400 font-semibold text-sm">
                                    {{ __('common.delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    function toggleForm() {
        const formContainer = document.getElementById('formContainer');
        formContainer.classList.toggle('hidden');
        
        // Scroll to form if opening
        if (!formContainer.classList.contains('hidden')) {
            formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
@endsection
