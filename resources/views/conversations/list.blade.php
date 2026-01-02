@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-white mb-8">Messages</h1>

    @if($conversations->isEmpty())
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-8 text-center">
            <p class="text-gray-400 mb-4">No conversations yet</p>
            <a href="{{ route('services') }}" class="text-indigo-400 hover:text-indigo-300">Start browsing services →</a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($conversations as $conversation)
                @php
                    $otherUser = auth()->id() === $conversation->user1_id ? $conversation->user2 : $conversation->user1;
                @endphp
                <a href="{{ route('conversations.show', $conversation) }}" class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:border-indigo-500 hover:bg-gray-800 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-white font-semibold">{{ $otherUser->fname }} {{ $otherUser->lname }}</h3>
                            <p class="text-gray-400 text-sm">{{ $conversation->updated_at->diffForHumans() }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
