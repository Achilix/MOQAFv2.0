@extends('layouts.app')

@section('content')
<div class="bg-gray-900 rounded-lg shadow-lg p-8 w-full max-w-2xl mx-auto text-center mt-16">
  <h2 class="text-2xl font-bold text-white mb-2">Welcome to your Dashboard</h2>
  <p class="text-gray-400 mb-6">You have successfully registered and logged in.</p>
  <a href="{{ url('/') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-400">Go to Home</a>
</div>
@endsection
