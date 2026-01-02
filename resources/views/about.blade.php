@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl py-16 sm:py-24 lg:py-32 px-6">
  <!-- Hero Section -->
  <div class="text-center mb-16">
    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl mb-6">About MOQAF</h1>
    <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
      Your trusted platform connecting homeowners with skilled handymen across the region. Quality service, secure transactions, and peace of mind—every time.
    </p>
  </div>

  <!-- Mission Section -->
  <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 rounded-2xl p-10 border border-gray-700 mb-12">
    <h2 class="text-3xl font-bold text-white mb-6 text-center">Our Mission</h2>
    <p class="text-lg text-gray-300 leading-relaxed text-center max-w-3xl mx-auto">
      At MOQAF, we believe that finding reliable home services shouldn't be complicated, expensive, or risky. Our mission is to create a trustworthy marketplace where homeowners can easily find verified professionals, and skilled handymen can build thriving businesses—all on one secure platform.
    </p>
  </div>

  <!-- Values Grid -->
  <div class="grid md:grid-cols-3 gap-8 mb-16">
    <div class="bg-gray-800/50 rounded-xl p-8 border border-gray-700 text-center">
      <div class="bg-blue-900/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-blue-600">
        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-white mb-3">Trust & Safety</h3>
      <p class="text-gray-300 leading-relaxed">
        Every handyman on MOQAF is thoroughly verified with background checks, credential validation, and customer reviews to ensure your safety and satisfaction.
      </p>
    </div>

    <div class="bg-gray-800/50 rounded-xl p-8 border border-gray-700 text-center">
      <div class="bg-green-900/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-green-600">
        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-white mb-3">Community First</h3>
      <p class="text-gray-300 leading-relaxed">
        We build relationships, not just transactions. MOQAF fosters a supportive community where clients and handymen can communicate, collaborate, and grow together.
      </p>
    </div>

    <div class="bg-gray-800/50 rounded-xl p-8 border border-gray-700 text-center">
      <div class="bg-purple-900/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-purple-600">
        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-white mb-3">Innovation</h3>
      <p class="text-gray-300 leading-relaxed">
        Using cutting-edge technology, we make booking services seamless, payments secure, and communication instant—bringing the best of tech to home services.
      </p>
    </div>
  </div>

  <!-- What Makes Us Different -->
  <div class="bg-gradient-to-br from-blue-900/20 to-purple-900/20 rounded-2xl p-10 border border-blue-700/50 mb-12">
    <h2 class="text-3xl font-bold text-white mb-8 text-center">What Makes MOQAF Different?</h2>
    <div class="space-y-6">
      <div class="flex items-start gap-4">
        <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <div>
          <h4 class="text-lg font-bold text-white mb-2">Verified Professionals Only</h4>
          <p class="text-gray-300">Unlike other platforms, we manually verify every handyman's credentials, licenses, insurance, and work history before approval.</p>
        </div>
      </div>
      
      <div class="flex items-start gap-4">
        <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <div>
          <h4 class="text-lg font-bold text-white mb-2">Direct Communication</h4>
          <p class="text-gray-300">Chat directly with handymen before booking. Discuss details, ask questions, and set expectations without middleman interference.</p>
        </div>
      </div>
      
      <div class="flex items-start gap-4">
        <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <div>
          <h4 class="text-lg font-bold text-white mb-2">Transparent Pricing</h4>
          <p class="text-gray-300">No hidden fees or surprise charges. See exact costs upfront, compare quotes easily, and pay only when you're satisfied with the work.</p>
        </div>
      </div>
      
      <div class="flex items-start gap-4">
        <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <div>
          <h4 class="text-lg font-bold text-white mb-2">Payment Protection</h4>
          <p class="text-gray-300">Our secure escrow system holds payments until work is completed to your satisfaction, protecting both clients and handymen.</p>
        </div>
      </div>
      
      <div class="flex items-start gap-4">
        <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <div>
          <h4 class="text-lg font-bold text-white mb-2">Quality Guarantee</h4>
          <p class="text-gray-300">If you're not satisfied with the work, we'll help resolve the issue or refund your payment. Your satisfaction is our priority.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Section -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
    <div class="text-center">
      <div class="text-4xl font-bold text-white mb-2">1000+</div>
      <div class="text-gray-400">Verified Handymen</div>
    </div>
    <div class="text-center">
      <div class="text-4xl font-bold text-white mb-2">50K+</div>
      <div class="text-gray-400">Jobs Completed</div>
    </div>
    <div class="text-center">
      <div class="text-4xl font-bold text-white mb-2">4.8/5</div>
      <div class="text-gray-400">Average Rating</div>
    </div>
    <div class="text-center">
      <div class="text-4xl font-bold text-white mb-2">24/7</div>
      <div class="text-gray-400">Customer Support</div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="text-center bg-gray-800/50 rounded-2xl p-10 border border-gray-700">
    <h2 class="text-3xl font-bold text-white mb-4">Join the MOQAF Community Today</h2>
    <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
      Whether you need reliable home services or want to grow your handyman business, MOQAF is here to help you succeed.
    </p>
    <div class="flex gap-4 justify-center flex-wrap">
      <a href="{{ route('services') }}" class="inline-block rounded-md bg-blue-600 px-8 py-3 text-base font-semibold text-white shadow-lg hover:bg-blue-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
        Find a Handyman
      </a>
      <a href="{{ route('become-handyman') }}" class="inline-block rounded-md bg-green-600 px-8 py-3 text-base font-semibold text-white shadow-lg hover:bg-green-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
        Become a Handyman
      </a>
      <a href="/" class="inline-block rounded-md border border-gray-600 px-8 py-3 text-base font-semibold text-white hover:bg-gray-800">
        Back to Home
      </a>
    </div>
  </div>
</div>
@endsection
