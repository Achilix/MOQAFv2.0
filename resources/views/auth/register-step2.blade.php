@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
  body { overflow-y: auto !important; }
</style>
<div class="bg-black min-h-screen">
  <div class="relative isolate px-6 pt-10 lg:px-8">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
    </div>
    <div class="flex min-h-full flex-col justify-center px-6 py-4 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img src="/storage/logo/M.png" alt="MOQAF Logo" class="mx-auto h-16 w-auto" />
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Complete your profile</h2>
        <p class="mt-2 text-center text-sm/6 text-gray-400">Step 2 of 2 - Personal Details</p>
      </div>
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
        @if ($errors->any())
          <div class="mb-6">
            <ul class="list-disc list-inside text-red-500 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form action="{{ route('register.submit.step2') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
          @csrf
          <div class="space-y-6">
            <div>
              <label for="username" class="block text-sm font-medium text-white">Username (Optional)</label>
              <div class="mt-2 flex rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                <div class="shrink-0 text-base text-gray-400 select-none">MOQAF.com/</div>
                <input id="username" type="text" name="username" placeholder="janesmith" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none" />
              </div>
            </div>
            <div>
              <label for="about" class="block text-sm font-medium text-white">About (Optional)</label>
              <div class="mt-2">
                <textarea id="about" name="about" rows="3" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500"></textarea>
              </div>
              <p class="mt-3 text-sm text-gray-400">Write a few sentences about yourself.</p>
            </div>
            <div>
              <label for="photo" class="block text-sm font-medium text-white">Photo (Optional)</label>
              <div class="mt-2 flex items-center gap-x-3">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-12 text-gray-500">
                  <path d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                <input id="photo" type="file" name="photo" class="rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white" />
              </div>
            </div>
          </div>
          <div class="border-b border-white/10 pb-8 mt-8">
            <h2 class="text-base font-semibold text-white">Personal Information</h2>
            <p class="mt-1 text-sm text-gray-400">Use a permanent address where you can receive mail.</p>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
              <div class="sm:col-span-3">
                <label for="fname" class="block text-sm font-medium text-white">First name</label>
                <div class="mt-2">
                  <input id="fname" type="text" name="fname" required autocomplete="given-name" value="{{ old('fname') }}" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                  @error('fname') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
              </div>
              <div class="sm:col-span-3">
                <label for="lname" class="block text-sm font-medium text-white">Last name</label>
                <div class="mt-2">
                  <input id="lname" type="text" name="lname" required autocomplete="family-name" value="{{ old('lname') }}" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                  @error('lname') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
              </div>
              <div class="sm:col-span-4">
                <label for="email" class="block text-sm font-medium text-white">Email address</label>
                <div class="mt-2">
                  <input id="email" type="email" name="email" value="{{ session('register_email') }}" readonly class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                </div>
              </div>
              <div class="sm:col-span-3">
                <label for="phone_number" class="block text-sm font-medium text-white">Phone Number</label>
                <div class="mt-2">
                  <input id="phone_number" type="tel" name="phone_number" required value="{{ old('phone_number') }}" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                  @error('phone_number') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
              </div>
              <div class="sm:col-span-3">
                <label for="user_type" class="block text-sm font-medium text-white">Account Type</label>
                <div class="mt-2 flex gap-4">
                  <label class="flex items-center">
                    <input id="buyer" type="radio" name="user_type" value="buyer" required {{ old('user_type') == 'buyer' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-indigo-500 focus:ring-indigo-500" />
                    <span class="ml-2 text-sm text-gray-300">Buyer</span>
                  </label>
                  <label class="flex items-center">
                    <input id="seller" type="radio" name="user_type" value="seller" required {{ old('user_type') == 'seller' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-indigo-500 focus:ring-indigo-500" />
                    <span class="ml-2 text-sm text-gray-300">Seller</span>
                  </label>
                </div>
                @error('user_type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
              </div>
              <div class="sm:col-span-4">
                <label for="gov_id" class="block text-sm font-medium text-white">Government ID (Optional)</label>
                <div class="mt-2">
                  <input id="gov_id" type="file" name="gov_id" accept="image/*" class="block w-full text-white" />
                  @error('gov_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
              </div>
              <div class="col-span-full">
                <label for="address" class="block text-sm font-medium text-white">Address</label>
                <div class="mt-2">
                  <input id="address" type="text" name="address" required value="{{ old('address') }}" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                  @error('address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
              </div>
              <div class="sm:col-span-2 sm:col-start-1">
                <label for="city" class="block text-sm font-medium text-white">City (Optional)</label>
                <div class="mt-2">
                  <input id="city" type="text" name="city" value="{{ old('city') }}" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                  @error('city') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
              </div>
            </div>
          </div>
          <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold text-white" onclick="window.location.href='{{ route('register.step1') }}'">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create Account</button>
          </div>
        </form>
      </div>
    </div>
    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
    </div>
  </div>
</div>
