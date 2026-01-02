<!-- Chat Conversation Modal (Facebook Messenger Style) -->
<div id="chatWindows" class="fixed bottom-6 right-6 space-y-3 z-40 flex flex-col items-end"></div>

<template id="chatWindowTemplate">
  <div class="chat-window w-80 flex flex-col bg-gray-900 border border-gray-800 rounded-lg shadow-2xl" style="height: 450px; box-shadow: 0 5px 40px rgba(0,0,0,0.5);">
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-800 flex items-center justify-between bg-gray-800 cursor-move rounded-t-lg flex-shrink-0" draggable="true">
      <div class="flex-1 min-w-0">
        <h3 class="chat-title text-white font-bold text-sm truncate">Chat</h3>
      </div>
      <div class="flex gap-1 flex-shrink-0 ml-2">
        <button type="button" class="minimize-btn text-gray-400 hover:text-white text-lg focus:outline-none" title="Minimize">_</button>
        <button type="button" class="close-btn text-gray-400 hover:text-white text-lg focus:outline-none" title="Close">✕</button>
      </div>
    </div>

    <!-- Messages -->
    <div class="chat-messages flex-1 overflow-y-auto space-y-3 p-3 bg-gray-950"></div>

    <!-- Input -->
    <form class="chat-form px-4 py-3 border-t border-gray-800 bg-gray-900 rounded-b-lg flex-shrink-0">
      @csrf
      <div class="flex gap-2">
        <textarea class="chat-input flex-1 bg-gray-800 text-white placeholder-gray-500 border border-gray-700 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 resize-none" name="body" rows="2" placeholder="Type a message..." required></textarea>
        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-3 py-2 rounded text-sm flex-shrink-0 focus:outline-none">Send</button>
      </div>
    </form>
  </div>
</template>

<script>
const chatWindowsContainer = document.getElementById('chatWindows');
const chatWindowTemplate = document.getElementById('chatWindowTemplate');
let openWindows = {};

/**
 * Open or focus a conversation window
 */
function openConversation(conversationId, otherUserName) {
  // If already open, focus it
  if (openWindows[conversationId]) {
    openWindows[conversationId].window.scrollIntoView({ behavior: 'smooth', block: 'end' });
    return;
  }

  // Clone template
  const windowClone = chatWindowTemplate.content.cloneNode(true);
  
  // Append to container first
  chatWindowsContainer.appendChild(windowClone);
  
  // Now get the actual elements from the DOM
  const actualWindow = chatWindowsContainer.querySelector('.chat-window:last-child');
  const chatTitle = actualWindow.querySelector('.chat-title');
  const chatMessages = actualWindow.querySelector('.chat-messages');
  const chatForm = actualWindow.querySelector('.chat-form');
  const chatInput = actualWindow.querySelector('.chat-input');
  const closeBtn = actualWindow.querySelector('.close-btn');
  const minimizeBtn = actualWindow.querySelector('.minimize-btn');

  // Set header
  chatTitle.textContent = otherUserName;
  chatForm.dataset.conversationId = conversationId;

  const userId = {{ auth()->id() }};
  let isLoading = false;

  console.log('Window opened:', { conversationId, otherUserName, chatMessages, chatForm, chatInput });

  /**
   * Load messages from server
   */
  const loadMessages = async () => {
    if (isLoading) return;
    isLoading = true;

    try {
      const response = await fetch(`/conversations/${conversationId}/messages`);

      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }

      const text = await response.text();
      console.log('Raw response:', text);
      
      let data;
      try {
        data = JSON.parse(text);
      } catch (parseErr) {
        console.error('JSON parse error:', parseErr, 'Text:', text);
        throw new Error('Invalid JSON response');
      }

      console.log('Loaded messages:', data.messages);

      if (!data.success || !Array.isArray(data.messages)) {
        console.error('Invalid response:', data);
        throw new Error('Invalid response format');
      }

      // Clear and rebuild messages
      chatMessages.innerHTML = '';

      if (data.messages.length === 0) {
        chatMessages.innerHTML = '<p class="text-gray-500 text-center py-4 text-sm">No messages yet. Say hello!</p>';
        isLoading = false;
        return;
      }

      data.messages.forEach(msg => {
        const isMine = msg.sender_id === userId;
        const msgDiv = document.createElement('div');
        msgDiv.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;
        msgDiv.innerHTML = `
          <div class="px-3 py-2 rounded-lg text-sm max-w-xs ${isMine ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-100'}">
            <p>${escapeHtml(msg.body)}</p>
            <p class="text-xs text-gray-300 mt-1 text-right">${msg.created_at}</p>
          </div>
        `;
        chatMessages.appendChild(msgDiv);
      });

      // Auto scroll to bottom
      chatMessages.scrollTop = chatMessages.scrollHeight;
    } catch (error) {
      console.error('Failed to load messages:', error);
      chatMessages.innerHTML = '<p class="text-red-500 text-center py-4 text-sm">Error: ' + error.message + '</p>';
    } finally {
      isLoading = false;
    }
  };

  /**
   * Send message
   */
  chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const body = chatInput.value.trim();
    if (!body) return;

    // Clear input
    chatInput.value = '';
    chatInput.focus();

    // Show optimistic message
    const msgDiv = document.createElement('div');
    msgDiv.className = 'flex justify-end';
    msgDiv.innerHTML = `
      <div class="px-3 py-2 rounded-lg text-sm max-w-xs bg-indigo-600 text-white">
        <p>${escapeHtml(body)}</p>
        <p class="text-xs text-gray-300 mt-1 text-right">sending...</p>
      </div>
    `;
    chatMessages.appendChild(msgDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Send to server
    try {
      const csrfToken = chatForm.querySelector('input[name="_token"]').value;
      const response = await fetch(`/conversations/${conversationId}/messages`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ body }),
      });

      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }

      const data = await response.json();
      if (!data.success) {
        throw new Error('Server returned error');
      }

      // Reload messages to show confirmed message
      await loadMessages();
    } catch (error) {
      console.error('Failed to send message:', error);
      msgDiv.querySelector('p:last-child').textContent = 'failed to send';
    }
  });

  /**
   * Close window
   */
  closeBtn.addEventListener('click', () => {
    actualWindow.remove();
    delete openWindows[conversationId];
  });

  /**
   * Minimize window
   */
  minimizeBtn.addEventListener('click', () => {
    const messages = actualWindow.querySelector('.chat-messages');
    const form = actualWindow.querySelector('.chat-form');
    const isHidden = messages.classList.contains('hidden');

    if (isHidden) {
      messages.classList.remove('hidden');
      form.classList.remove('hidden');
      actualWindow.style.height = '450px';
      minimizeBtn.textContent = '_';
    } else {
      messages.classList.add('hidden');
      form.classList.add('hidden');
      actualWindow.style.height = 'auto';
      minimizeBtn.textContent = '+';
    }
  });

  // Store reference
  openWindows[conversationId] = {
    window: actualWindow,
  };

  // Load initial messages
  loadMessages();

  // Poll for new messages every 3 seconds
  const pollInterval = setInterval(() => {
    if (openWindows[conversationId]) {
      loadMessages();
    } else {
      clearInterval(pollInterval);
    }
  }, 3000);
}

/**
 * Escape HTML to prevent XSS
 */

