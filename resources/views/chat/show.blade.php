@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-800 bg-gray-800">
            <h2 class="text-xl font-bold text-white">
                @php
                    $otherUser = auth()->id() === $conversation->user1_id ? $conversation->user2 : $conversation->user1;
                @endphp
                {{ $otherUser->fname }} {{ $otherUser->lname }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">{{ $conversation->updated_at->diffForHumans() }}</p>
        </div>

        <!-- Messages -->
        <div id="messages" class="h-96 overflow-y-auto p-6 space-y-4 bg-gray-950">
            <p class="text-gray-500 text-center py-4">Loading messages...</p>
        </div>

        <!-- Form -->
        <form id="messageForm" class="px-6 py-4 border-t border-gray-800 bg-gray-900">
            @csrf
            <div class="flex gap-3">
                <textarea id="messageInput" name="body" rows="2" class="flex-1 bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500" placeholder="Type a message..." required></textarea>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg whitespace-nowrap">Send</button>
            </div>
        </form>
    </div>
</div>

<script>
const conversationId = {{ $conversation->id }};
const userId = {{ auth()->id() }};
const messagesDiv = document.getElementById('messages');
const messageForm = document.getElementById('messageForm');
const messageInput = document.getElementById('messageInput');

/**
 * Load messages from server
 */
async function loadMessages() {
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

    console.log('Fetched messages:', data);

    if (!data.success || !Array.isArray(data.messages)) {
      throw new Error('Invalid response format');
    }

    // Clear and rebuild messages
    messagesDiv.innerHTML = '';

    if (data.messages.length === 0) {
      messagesDiv.innerHTML = '<p class="text-gray-500 text-center py-4">No messages yet. Start the conversation!</p>';
      return;
    }

    data.messages.forEach(msg => {
      const isMine = msg.sender_id === userId;
      const msgDiv = document.createElement('div');
      msgDiv.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;
      msgDiv.innerHTML = `
        <div class="px-4 py-3 rounded-lg max-w-xs ${isMine ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-100'}">
          <p class="text-sm">${escapeHtml(msg.body)}</p>
          <p class="text-xs text-gray-300 mt-2 ${isMine ? 'text-right' : ''}">${msg.created_at}</p>
        </div>
      `;
      messagesDiv.appendChild(msgDiv);
    });

    // Auto scroll to bottom
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
  } catch (error) {
    console.error('Failed to load messages:', error);
    messagesDiv.innerHTML = '<p class="text-red-500 text-center py-4">Error: ' + error.message + '</p>';
  }
}

/**
 * Send message
 */
messageForm.addEventListener('submit', async (e) => {
  e.preventDefault();

  const body = messageInput.value.trim();
  if (!body) return;

  messageInput.value = '';
  messageInput.focus();

  // Show optimistic message
  const msgDiv = document.createElement('div');
  msgDiv.className = 'flex justify-end';
  msgDiv.innerHTML = `
    <div class="px-4 py-3 rounded-lg max-w-xs bg-indigo-600 text-white">
      <p class="text-sm">${escapeHtml(body)}</p>
      <p class="text-xs text-gray-300 mt-2 text-right">sending...</p>
    </div>
  `;
  messagesDiv.appendChild(msgDiv);
  messagesDiv.scrollTop = messagesDiv.scrollHeight;

  // Send to server
  try {
    const response = await fetch(`/conversations/${conversationId}/messages`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
      },
      body: JSON.stringify({ body }),
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    const data = await response.json();
    if (!data.success) {
      throw new Error('Server error');
    }

    // Reload messages to show confirmed message
    await loadMessages();
  } catch (error) {
    console.error('Failed to send message:', error);
    msgDiv.querySelector('p:last-child').textContent = 'failed to send';
  }
});

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Load initial messages
loadMessages();

// Poll for new messages every 3 seconds
setInterval(loadMessages, 3000);
</script>
@endsection

