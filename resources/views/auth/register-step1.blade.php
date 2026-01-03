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
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img src="/storage/logo/M.png" alt="MOQAF Logo" class="mx-auto h-20 w-auto" />
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Create your account</h2>
        <p class="mt-2 text-center text-sm/6 text-gray-400">Step 1 of 2 - Email & Password</p>
      </div>
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form action="{{ route('register.submit.step1') }}" method="POST" class="space-y-6">
          @csrf
          <div>
            <label for="email" class="block text-sm/6 font-medium text-gray-100">Email address</label>
            <div class="mt-2">
              <input id="email" type="email" name="email" required autocomplete="email" value="{{ old('email') }}" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
              @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
          </div>
          <div>
            <label for="password" class="block text-sm/6 font-medium text-gray-100">Password</label>
            <div class="mt-2">
              <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
              @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
          </div>
          <div>
            <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-100">Confirm Password</label>
            <div class="mt-2">
              <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
          </div>

          <div class="flex items-start">
            <div class="flex h-6 items-center">
              <input id="agree_terms" name="agree_terms" type="checkbox" required class="h-4 w-4 rounded border-gray-500 bg-white/5 text-indigo-500 focus:ring-indigo-500" />
            </div>
            <div class="ml-3 text-sm/6">
              <label for="agree_terms" class="font-medium text-gray-100">
                I agree to the 
                <a href="{{ route('terms-and-conditions') }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 underline">Terms and Conditions</a>
              </label>
              <p class="mt-1 text-gray-500 text-xs">You must agree to our terms and conditions to continue. Read them carefully as they include important liability disclaimers.</p>
              @error('agree_terms') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
          </div>
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Next Step</button>
          </div>
        </form>
        <p class="mt-10 text-center text-sm/6 text-gray-400">
          Already have an account?
          <a href="{{ route('login') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">Sign in</a>
        </p>
      </div>
    </div>
  </div>
</div>
