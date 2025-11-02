@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md py-24 sm:py-40 lg:py-48">
  <div class="bg-white/10 rounded-xl p-8 shadow-lg">
    <h1 class="text-3xl font-bold text-white mb-8 text-center">Sign Up</h1>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="mb-4">
        <label class="block text-white mb-2" for="name">Name</label>
        <input id="name" name="name" type="text" required autofocus class="w-full rounded-md border-0 px-3 py-2 bg-white/20 text-white placeholder-gray-300 focus:ring-2 focus:ring-indigo-500" />
      </div>
      <div class="mb-4">
        <label class="block text-white mb-2" for="email">Email</label>
        <input id="email" name="email" type="email" required class="w-full rounded-md border-0 px-3 py-2 bg-white/20 text-white placeholder-gray-300 focus:ring-2 focus:ring-indigo-500" />
      </div>
      <div class="mb-6">
        <label class="block text-white mb-2" for="password">Password</label>
        <input id="password" name="password" type="password" required class="w-full rounded-md border-0 px-3 py-2 bg-white/20 text-white placeholder-gray-300 focus:ring-2 focus:ring-indigo-500" />
      </div>
      <button type="submit" class="w-full rounded-md bg-black px-4 py-2 text-sm font-semibold text-white shadow-xs hover:bg-gray-800">Sign Up</button>
    </form>
    <div class="mt-6 text-center">
      <a href="{{ route('login') }}" class="text-indigo-300 hover:underline">Already have an account? Sign In</a>
    </div>
  </div>
</div>
@endsection
