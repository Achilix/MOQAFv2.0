@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl py-16 sm:py-24 lg:py-32 px-6">
  <!-- Hero Section -->
  <div class="text-center mb-16">
    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl mb-6">How MOQAF Works</h1>
    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
      Connecting skilled handymen with homeowners—simple, secure, and reliable service in just a few clicks.
    </p>
  </div>

  <!-- Two Column Layout -->
  <div class="grid gap-12 lg:grid-cols-2 mb-16">
    <!-- Client Section -->
    <div class="bg-gradient-to-br from-blue-900/30 to-blue-800/20 rounded-2xl p-8 border border-blue-700/50">
      <div class="flex items-center gap-3 mb-8">
        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <h2 class="text-3xl font-bold text-white">For Clients</h2>
      </div>
      
      <div class="space-y-8">
        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-blue-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">1</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">Browse Available Services</h3>
            <p class="text-gray-300 leading-relaxed">
              Explore hundreds of skilled handymen offering services from plumbing and electrical work to carpentry and painting. Filter by location, price, ratings, and availability to find the perfect match.
            </p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-blue-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">2</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">Review & Select Your Handyman</h3>
            <p class="text-gray-300 leading-relaxed">
              Check detailed profiles with verified credentials, customer reviews, completed projects, and ratings. Compare quotes and portfolios before making your choice—all transparently displayed.
            </p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-blue-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">3</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">Book & Communicate Directly</h3>
            <p class="text-gray-300 leading-relaxed">
              Message your handyman directly through our secure chat. Discuss project details, schedule a convenient time, and clarify any questions before work begins.
            </p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-blue-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">4</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">Get the Job Done & Pay Securely</h3>
            <p class="text-gray-300 leading-relaxed">
              Your handyman completes the work professionally. Pay securely through MOQAF when satisfied. Leave a review to help the community and enjoy our satisfaction guarantee.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Handyman Section -->
    <div class="bg-gradient-to-br from-green-900/30 to-green-800/20 rounded-2xl p-8 border border-green-700/50">
      <div class="flex items-center gap-3 mb-8">
        <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <h2 class="text-3xl font-bold text-white">For Handymen</h2>
      </div>
      
      <div class="space-y-8">
        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-green-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">1</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">Create Your Professional Profile</h3>
            <p class="text-gray-300 leading-relaxed">
              Sign up for free and build a compelling profile. Showcase your skills, certifications, past projects with photos, and set your service rates. Your profile is your digital storefront.
            </p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-green-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">2</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">List Your Services & Availability</h3>
            <p class="text-gray-300 leading-relaxed">
              Create service listings (gigs) for your specialties—plumbing, electrical, carpentry, and more. Set your prices, working hours, service areas, and upload project photos to attract clients.
            </p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-green-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">3</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">Receive Bookings & Communicate</h3>
            <p class="text-gray-300 leading-relaxed">
              Get notified when clients are interested in your services. Chat directly with potential clients, discuss project requirements, confirm schedules, and answer questions in real-time.
            </p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 rounded-full bg-green-500 text-white w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg">4</div>
          <div>
            <h3 class="text-xl font-bold text-white mb-2">Complete Work & Get Paid Fast</h3>
            <p class="text-gray-300 leading-relaxed">
              Deliver quality service and get paid securely through MOQAF's payment system. Build your reputation with 5-star reviews, grow your client base, and expand your business on your own terms.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="bg-gray-800/50 rounded-2xl p-8 border border-gray-700 mb-16">
    <h2 class="text-3xl font-bold text-white mb-8 text-center">Why Choose MOQAF?</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="text-center">
        <div class="bg-purple-900/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-purple-600">
          <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Verified & Trusted</h3>
        <p class="text-gray-300">All handymen are verified with background checks and credentials validation for your safety and peace of mind.</p>
      </div>
      
      <div class="text-center">
        <div class="bg-yellow-900/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-yellow-600">
          <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Secure Payments</h3>
        <p class="text-gray-300">Protected transactions with escrow service. Clients pay only after satisfaction, handymen receive guaranteed payments.</p>
      </div>
      
      <div class="text-center">
        <div class="bg-red-900/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-red-600">
          <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">24/7 Support</h3>
        <p class="text-gray-300">Our customer support team is always ready to help resolve issues and ensure smooth transactions for everyone.</p>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="text-center">
    <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
    <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
      Whether you need help with home repairs or want to offer your professional services, MOQAF makes it easy.
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
