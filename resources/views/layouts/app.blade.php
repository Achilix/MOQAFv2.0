<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'MOQAF') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black min-h-screen">
  <div class="relative">
    {{-- Background Gradients --}}
    <div aria-hidden="true" class="fixed inset-x-0 top-0 -z-10 transform-gpu overflow-hidden blur-3xl pointer-events-none">
    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"></div>
  </div>
  <div aria-hidden="true" class="fixed inset-x-0 top-1/3 -z-10 transform-gpu overflow-hidden blur-3xl pointer-events-none">
    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"></div>
  </div>
  <div aria-hidden="true" class="fixed inset-x-0 top-2/3 -z-10 transform-gpu overflow-hidden blur-3xl pointer-events-none">
    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"></div>
  </div>
  <header class="fixed inset-x-0 top-0 z-50 bg-black/80 backdrop-blur-sm border-b border-gray-800">
    <nav aria-label="Global" class="flex items-center justify-between py-4 px-6 lg:px-8 min-h-[80px]">
      <div class="flex lg:flex-1">
        <a href="{{ auth()->check() ? route('home') : route('landing') }}" class="-m-1.5 p-1.5">
          <span class="sr-only">MOQAF</span>
          <img src="/storage/logo/M.png" alt="MOQAF Logo" class="h-15 w-auto" />
        </a>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
        @auth
          @php
            $user = Auth::user();
            $isHandyman = $user->isHandyman();
            $isClient = $user->isClient();
          @endphp
          
          @if($isHandyman)
            {{-- Handyman Navigation --}}
            <a href="{{ route('home') }}" class="text-sm/6 font-semibold {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.home') }}</a>
            <a href="{{ route('dashboard') }}" class="text-sm/6 font-semibold {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.dashboard') }}</a>
            <a href="{{ route('my-gigs') }}" class="text-sm/6 font-semibold {{ request()->routeIs('my-gigs') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.my_gigs') }}</a>
            <a href="#" class="text-sm/6 font-semibold text-gray-400 hover:text-white">{{ __('common.my_orders') }}</a>
          @elseif($isClient)
            {{-- Client Navigation --}}
            <a href="{{ route('home') }}" class="text-sm/6 font-semibold {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.home') }}</a>
            <a href="{{ route('dashboard') }}" class="text-sm/6 font-semibold {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.dashboard') }}</a>
            <a href="{{ route('services') }}" class="text-sm/6 font-semibold {{ request()->routeIs('services') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.find_a_handyman') }}</a>
            <a href="#" class="text-sm/6 font-semibold text-gray-400 hover:text-white">{{ __('common.my_orders') }}</a>
          @else
            {{-- Default authenticated user --}}
            <a href="{{ route('home') }}" class="text-sm/6 font-semibold {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.home') }}</a>
            <a href="{{ route('dashboard') }}" class="text-sm/6 font-semibold {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.dashboard') }}</a>
            <a href="{{ route('how-it-works') }}" class="text-sm/6 font-semibold {{ request()->routeIs('how-it-works') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.how_it_works') }}</a>
            <a href="/about" class="text-sm/6 font-semibold {{ request()->is('about') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.about_moqaf') }}</a>
          @endif
        @else
          {{-- Guest Navigation --}}
          <a href="{{ route('how-it-works') }}" class="text-sm/6 font-semibold {{ request()->routeIs('how-it-works') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.how_it_works') }}</a>
          <a href="{{ route('services') }}" class="text-sm/6 font-semibold {{ request()->routeIs('services') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.find_a_handyman') }}</a>
          <a href="#" class="text-sm/6 font-semibold text-gray-400 hover:text-white">{{ __('common.become_handyman') }}</a>
          <a href="/about" class="text-sm/6 font-semibold {{ request()->is('about') ? 'text-white' : 'text-gray-400 hover:text-white' }}">{{ __('common.about_moqaf') }}</a>
        @endauth
      </div>
      <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-x-4 items-center">
        @auth
          <!-- Messages Bell Icon -->
          <a href="{{ route('conversations.list') }}" class="relative text-sm/6 font-semibold text-gray-400 hover:text-white transition-colors" title="Messages">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
          </a>
        @endauth

                {{-- Language Switcher --}}
                <div class="relative group">
                  <button class="text-sm/6 font-semibold text-gray-400 hover:text-white flex items-center gap-1">
                    🌐 {{ strtoupper(app()->getLocale()) }}
                    <span aria-hidden="true">▼</span>
                  </button>
                  <div class="absolute right-0 mt-0 w-32 bg-gray-800 border border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white {{ app()->getLocale() === 'en' ? 'bg-indigo-500 text-white' : '' }}">
                      🇬🇧 English
                    </a>
                    <a href="{{ route('language.switch', 'fr') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white {{ app()->getLocale() === 'fr' ? 'bg-indigo-500 text-white' : '' }}">
                      🇫🇷 Français
                    </a>
                    <a href="{{ route('language.switch', 'ar') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white {{ app()->getLocale() === 'ar' ? 'bg-indigo-500 text-white' : '' }}">
                      🇸🇦 العربية
                    </a>
                  </div>
                </div>

        @auth
          <span class="text-sm text-gray-400">{{ Auth::user()->fname }}</span>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm/6 font-semibold text-white hover:text-gray-300">
              {{ __('common.sign_out') }} <span aria-hidden="true">&rarr;</span>
            </button>
          </form>
        @else
          <a href="/login" class="text-sm/6 font-semibold text-white">{{ __('common.sign_in') }} <span aria-hidden="true">&rarr;</span></a>
        @endauth
      </div>
    </nav>
  </header>
  <div class="relative px-6 pt-32 lg:px-8">
    @yield('content')
  </div>

  {{-- Chat Bubble (only for authenticated users) --}}
  @auth
  @include('chat.modal')
  <div id="chatBubble" class="fixed bottom-6 right-6 z-30 flex flex-col items-end gap-3">
    <!-- Chat Widget Container -->
    <div id="chatWidget" class="hidden flex flex-col h-96 w-80 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl">
      <!-- Header -->
      <div class="px-4 py-3 border-b border-gray-800 flex items-center justify-between bg-gray-800">
        <h3 class="text-white font-bold text-sm">Messages</h3>
        <button id="closeChatWidget" class="text-gray-400 hover:text-white text-lg">✕</button>
      </div>

      <!-- Conversations List -->
      <div id="conversationsList" class="flex-1 overflow-y-auto space-y-2 p-3">
        <p class="text-gray-400 text-sm text-center py-4">Loading conversations...</p>
      </div>
    </div>

    <!-- Bubble Button -->
    <button id="chatBubbleBtn" class="w-14 h-14 bg-indigo-500 hover:bg-indigo-600 rounded-full shadow-lg flex items-center justify-center text-white text-xl transition transform hover:scale-110">
      <span class="text-2xl">💬</span>
      <span id="unreadBadge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center hidden">0</span>
    </button>
  </div>

  <script>
    const chatBubbleBtn = document.getElementById('chatBubbleBtn');
    const chatWidget = document.getElementById('chatWidget');
    const closeChatWidget = document.getElementById('closeChatWidget');
    const conversationsList = document.getElementById('conversationsList');
    const unreadBadge = document.getElementById('unreadBadge');
    const listUrl = "{{ route('conversations.list') }}";

    // Toggle chat widget
    chatBubbleBtn.addEventListener('click', () => {
      chatWidget.classList.toggle('hidden');
      if (!chatWidget.classList.contains('hidden')) {
        loadConversations();
      }
    });

    // Close chat widget
    closeChatWidget.addEventListener('click', (e) => {
      e.stopPropagation();
      chatWidget.classList.add('hidden');
    });

    // Load conversations
    function loadConversations() {
      fetch(listUrl)
        .then(res => res.json())
        .then(data => {
          if (data.conversations.length === 0) {
            conversationsList.innerHTML = '<p class="text-gray-500 text-sm text-center py-4">No conversations yet</p>';
            return;
          }

          conversationsList.innerHTML = '';
          data.conversations.forEach(conv => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'w-full text-left px-3 py-2 rounded-lg hover:bg-gray-800 border border-transparent hover:border-gray-700 transition';
            button.innerHTML = `
              <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                  <p class="text-white text-sm font-semibold truncate">${escapeHtml(conv.other_user)}</p>
                  <p class="text-gray-400 text-xs truncate">${escapeHtml(conv.gig_title)}</p>
                  <p class="text-gray-500 text-xs mt-1">${conv.last_message_at}</p>
                </div>
                ${conv.unread ? '<span class="bg-indigo-500 w-2 h-2 rounded-full ml-2 mt-1 flex-shrink-0"></span>' : ''}
              </div>
            `;
            button.addEventListener('click', () => {
              chatWidget.classList.add('hidden');
              openConversation(conv.id, conv.other_user, conv.gig_title);
            });
            conversationsList.appendChild(button);
          });
        })
        .catch(err => {
          conversationsList.innerHTML = '<p class="text-red-500 text-xs text-center py-4">Failed to load</p>';
        });
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    // Load conversations on page load
    loadConversations();

    // Poll for new conversations every 5 seconds
    setInterval(loadConversations, 5000);

    // Close widget when clicking outside
    document.addEventListener('click', (e) => {
      if (!chatBubbleBtn.contains(e.target) && !chatWidget.contains(e.target)) {
        chatWidget.classList.add('hidden');
      }
    });
  </script>
  @endauth
  </div>
</body>
</html>
