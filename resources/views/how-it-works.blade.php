@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl py-24 sm:py-40 lg:py-48">
  <div class="text-center">
    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl mb-8">How MOQAF Works</h1>
  </div>
  <div class="grid gap-16 md:grid-cols-2">
    <!-- Client Section -->
    <div>
      <h2 class="text-2xl font-semibold text-white mb-6 text-center">For Clients</h2>
      <ol class="space-y-10 text-left">
        <li class="flex items-start gap-4">
          <span class="flex-shrink-0 rounded-full bg-black text-white w-10 h-10 flex items-center justify-center text-xl font-bold">1</span>
          <div>
            <h3 class="text-lg font-semibold text-white mb-1">Post Your Task</h3>
            <p class="text-gray-300">Describe your home repair or improvement need. Add details, photos, and your location to help us match you with the right handyman.</p>
          </div>
        </li>
        <li class="flex items-start gap-4">
          <span class="flex-shrink-0 rounded-full bg-black text-white w-10 h-10 flex items-center justify-center text-xl font-bold">2</span>
          <div>
            <h3 class="text-lg font-semibold text-white mb-1">Get Matched Instantly</h3>
            <p class="text-gray-300">MOQAF connects you with skilled, vetted handymen in your area. Review profiles, ratings, and quotes before you choose.</p>
          </div>
        </li>
        <li class="flex items-start gap-4">
          <span class="flex-shrink-0 rounded-full bg-black text-white w-10 h-10 flex items-center justify-center text-xl font-bold">3</span>
          <div>
            <h3 class="text-lg font-semibold text-white mb-1">Book & Relax</h3>
            <p class="text-gray-300">Schedule your service at a convenient time. Pay securely through MOQAF and enjoy peace of mind with our satisfaction guarantee.</p>
          </div>
        </li>
      </ol>
    </div>
    <!-- Handyman Section -->
    <div>
      <h2 class="text-2xl font-semibold text-white mb-6 text-center">For Handymen</h2>
      <ol class="space-y-10 text-left">
        <li class="flex items-start gap-4">
          <span class="flex-shrink-0 rounded-full bg-black text-white w-10 h-10 flex items-center justify-center text-xl font-bold">1</span>
          <div>
            <h3 class="text-lg font-semibold text-white mb-1">Sign Up & Create Profile</h3>
            <p class="text-gray-300">Register as a handyman, complete your profile, and showcase your skills, experience, and certifications.</p>
          </div>
        </li>
        <li class="flex items-start gap-4">
          <span class="flex-shrink-0 rounded-full bg-black text-white w-10 h-10 flex items-center justify-center text-xl font-bold">2</span>
          <div>
            <h3 class="text-lg font-semibold text-white mb-1">Get Matched to Jobs</h3>
            <p class="text-gray-300">Receive instant notifications for tasks that match your skills and location. Respond with your quote and availability.</p>
          </div>
        </li>
        <li class="flex items-start gap-4">
          <span class="flex-shrink-0 rounded-full bg-black text-white w-10 h-10 flex items-center justify-center text-xl font-bold">3</span>
          <div>
            <h3 class="text-lg font-semibold text-white mb-1">Complete Tasks & Get Paid</h3>
            <p class="text-gray-300">Deliver quality service, get reviewed by clients, and receive secure payments directly through MOQAF.</p>
          </div>
        </li>
      </ol>
    </div>
  </div>
  <div class="mt-16 text-center">
    <a href="/" class="inline-block rounded-md bg-black px-4 py-2 text-sm font-semibold text-white shadow-xs hover:bg-gray-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">Back to Home</a>
  </div>
</div>
@endsection
