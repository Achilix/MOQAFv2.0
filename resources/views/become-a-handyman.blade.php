@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl py-16 sm:py-24 lg:py-32 px-6">
  <!-- Hero Section -->
  <div class="text-center mb-16">
    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl mb-6">
      Become a MOQAF Handyman
    </h1>
    <p class="text-xl text-gray-300 max-w-2xl mx-auto">
      Turn your skills into income. Join thousands of skilled professionals earning on their own schedule.
    </p>
  </div>

  <!-- Benefits Section -->
  <div class="grid gap-8 md:grid-cols-2 mb-16">
    <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
      <div class="flex items-center gap-3 mb-4">
        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="text-xl font-semibold text-white">Flexible Earnings</h3>
      </div>
      <p class="text-gray-300">
        Set your own rates and work schedule. Keep 100% of your earnings with transparent, on-time payments after each completed job.
      </p>
    </div>

    <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
      <div class="flex items-center gap-3 mb-4">
        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="text-xl font-semibold text-white">Verified Clients</h3>
      </div>
      <p class="text-gray-300">
        Work with verified clients and enjoy secure payments. MOQAF handles payment processing, so you can focus on quality work.
      </p>
    </div>

    <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
      <div class="flex items-center gap-3 mb-4">
        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        <h3 class="text-xl font-semibold text-white">Instant Job Matches</h3>
      </div>
      <p class="text-gray-300">
        Get notified immediately when jobs matching your skills and location are posted. Respond fast and grow your client base.
      </p>
    </div>

    <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
      <div class="flex items-center gap-3 mb-4">
        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
        </svg>
        <h3 class="text-xl font-semibold text-white">Build Your Reputation</h3>
      </div>
      <p class="text-gray-300">
        Earn positive reviews and ratings to attract more clients. Build your professional profile and showcase your expertise.
      </p>
    </div>
  </div>

  <!-- How to Get Started -->
  <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 rounded-xl p-8 border border-gray-700 mb-16">
    <h2 class="text-3xl font-bold text-white mb-8 text-center">How to Get Started</h2>
    <div class="space-y-6">
      <div class="flex items-start gap-4">
        <span class="flex-shrink-0 rounded-full bg-white text-black w-10 h-10 flex items-center justify-center text-lg font-bold">1</span>
        <div>
          <h4 class="text-lg font-semibold text-white mb-2">Create Your Account</h4>
          <p class="text-gray-300">Sign up and select "Handyman" as your account type. Complete your profile with your skills, experience, and certifications.</p>
        </div>
      </div>
      <div class="flex items-start gap-4">
        <span class="flex-shrink-0 rounded-full bg-white text-black w-10 h-10 flex items-center justify-center text-lg font-bold">2</span>
        <div>
          <h4 class="text-lg font-semibold text-white mb-2">Verification Process</h4>
          <p class="text-gray-300">Submit your credentials and complete a quick verification. We ensure quality and safety for all platform users.</p>
        </div>
      </div>
      <div class="flex items-start gap-4">
        <span class="flex-shrink-0 rounded-full bg-white text-black w-10 h-10 flex items-center justify-center text-lg font-bold">3</span>
        <div>
          <h4 class="text-lg font-semibold text-white mb-2">Start Accepting Jobs</h4>
          <p class="text-gray-300">Browse available gigs, submit quotes, and start earning. Build your reputation with quality work and great reviews.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="text-center">
    <h3 class="text-2xl font-bold text-white mb-4">Ready to Start Earning?</h3>
    <p class="text-gray-300 mb-8 max-w-xl mx-auto">
      Join MOQAF today and connect with clients who need your skills. It's free to sign up and easy to get started.
    </p>
    <div class="flex gap-4 justify-center">
      <a href="{{ route('register') }}" class="inline-block rounded-md bg-white px-6 py-3 text-base font-semibold text-black shadow-sm hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
        Register as Handyman
      </a>
      <a href="/" class="inline-block rounded-md border border-gray-600 px-6 py-3 text-base font-semibold text-white hover:bg-gray-800">
        Back to Home
      </a>
    </div>
  </div>
</div>
@endsection
