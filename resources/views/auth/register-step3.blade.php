@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
  body { overflow: hidden; }
</style>
<div class="bg-black min-h-screen">
  <div class="relative isolate px-6 pt-10 lg:px-8">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
    </div>
    <div class="flex min-h-full flex-col justify-center px-6 py-4 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img src="/storage/logo/M.png" alt="MOQAF Logo" class="mx-auto h-16 w-auto" />
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Seller Information</h2>
        <p class="mt-2 text-center text-sm/6 text-gray-400">Step 3 of 3 - Handyman Details</p>
      </div>
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
        <form action="{{ route('register.submit.step3') }}" method="POST" class="space-y-8">
          @csrf
          <div>
            <label class="block text-sm/6 font-medium text-gray-100 mb-2">Services Offered <span class="text-red-500">*</span></label>
            <div class="flex flex-wrap gap-4 mb-2">
              @php
                $serviceOptions = [
                  'painting' => 'Painting',
                  'carpentry' => 'Carpentry',
                  'cleaning' => 'Cleaning',
                  'gardening' => 'Gardening',
                  'moving' => 'Moving',
                  'appliance_repair' => 'Appliance Repair',
                ];
                $oldServices = old('services', []);
              @endphp
              @foreach($serviceOptions as $value => $label)
                <label class="inline-flex items-center space-x-2">
                  <input
                    type="checkbox"
                    name="services[]"
                    value="{{ $value }}"
                    class="form-checkbox h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                    {{ in_array($value, $oldServices) ? 'checked' : '' }}
                  >
                  <span class="text-white">{{ $label }}</span>
                </label>
              @endforeach
            </div>
            <p class="mt-2 text-xs text-gray-400">Select all services you offer.</p>
            @error('services') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="bio" class="block text-sm/6 font-medium text-gray-100">Bio (Optional)</label>
            <div class="mt-2">
              <textarea id="bio" name="bio" rows="4" placeholder="Tell us about yourself..." class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">{{ old('bio') }}</textarea>
              @error('bio') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
          </div>
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Complete Registration</button>
          </div>
        </form>
      </div>
    </div>
    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
    </div>
  </div>
</div>
