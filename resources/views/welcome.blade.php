@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
  <div class="hidden sm:mb-8 sm:flex sm:justify-center">
    <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-400 ring-1 ring-white/10 hover:ring-white/20">
      Need help around the house? <a href="#" class="font-semibold text-white"><span aria-hidden="true" class="absolute inset-0"></span>Discover MOQAF <span aria-hidden="true">&rarr;</span></a>
    </div>
  </div>
  <div class="text-center">
    <h1 class="text-5xl font-semibold tracking-tight text-balance text-white sm:text-7xl">Find Trusted Handymen Near You with MOQAF</h1>
    <p class="mt-8 text-lg font-medium text-pretty text-gray-400 sm:text-xl/8">
      MOQAF connects you with skilled and reliable handymen for all your home repair and improvement needs. Fast, easy, and secure handyman services at your fingertips.
    </p>
    <div class="mt-10 flex items-center justify-center gap-x-6">
      <a href="#" class="rounded-md bg-black px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-gray-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">Find a Handyman</a>
      <a href="#" class="text-sm/6 font-semibold text-white">Become a Handyman <span aria-hidden="true">→</span></a>
    </div>
  </div>
</div>
@endsection
