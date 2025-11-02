@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
  body { overflow: hidden; }
</style>
<div class="bg-black min-h-screen">
  <div class="relative isolate px-6 pt-24 lg:px-8">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
    </div>
    <div class="mx-auto max-w-md py-24 sm:py-40 lg:py-48">
      <div class="rounded-xl p-8 shadow-lg">
        <h1 class="text-3xl font-bold text-white mb-8 text-center">Sign In</h1>
        @if ($errors->any())
          <div class="mb-6">
            <ul class="list-disc list-inside text-red-500 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-4">
            <label class="block text-white mb-2" for="email">Email</label>
            <input id="email" name="email" type="email" required autofocus class="w-full rounded-md border-0 px-3 py-2 bg-white/20 text-white placeholder-gray-300 focus:ring-2 focus:ring-indigo-500" />
          </div>
          <div class="mb-6">
            <label class="block text-white mb-2" for="password">Password</label>
            <input id="password" name="password" type="password" required class="w-full rounded-md border-0 px-3 py-2 bg-white/20 text-white placeholder-gray-300 focus:ring-2 focus:ring-indigo-500" />
          </div>
          <button type="submit" class="w-full rounded-md bg-black px-4 py-2 text-sm font-semibold text-white shadow-xs hover:bg-gray-800">Sign In</button>
        </form>
        <div class="mt-6 text-center">
          <a href="{{ route('register') }}" class="text-indigo-300 hover:underline">Don't have an account? Sign Up</a>
        </div>
      </div>
    </div>
    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
    </div>
  </div>
</div>
