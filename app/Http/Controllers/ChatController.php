<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Start a new conversation with another user
     */
    public function start(Request $request)
    {
        $request->validate([
            'other_user_id' => ['required', 'exists:users,id'],
        ]);

        $userId = Auth::id();
        $otherUserId = $request->integer('other_user_id');

        if ($userId === $otherUserId) {
            return back()->with('error', 'Cannot start conversation with yourself');
        }

        // Ensure consistent ordering for unique constraint
        $user1Id = min($userId, $otherUserId);
        $user2Id = max($userId, $otherUserId);

        $conversation = Conversation::firstOrCreate([
            'user1_id' => $user1Id,
            'user2_id' => $user2Id,
        ]);

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Show conversations list page
     */
    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->with(['user1', 'user2'])
            ->orderByDesc('updated_at')
            ->get();

        return view('conversations.list', compact('conversations'));
    }

    /**
     * Show conversation page
     */
    public function show(Conversation $conversation)
    {
        $this->authorize($conversation);
        return view('chat.show', compact('conversation'));
    }

    /**
     * Fetch messages for a conversation (JSON API)
     */
    public function fetchMessages(Conversation $conversation)
    {
        try {
            $this->authorize($conversation);

            $messages = $conversation->messages()
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) {
                    return [
                        'id' => $msg->id,
                        'body' => $msg->body,
                        'sender_id' => $msg->sender_id,
                        'sender_name' => $msg->sender->fname . ' ' . $msg->sender->lname,
                        'created_at' => $msg->created_at->format('H:i'),
                        'created_at_human' => $msg->created_at->diffForHumans(),
                    ];
                })
                ->toArray();

            return response()->json([
                'success' => true,
                'messages' => $messages,
            ]);
        } catch (\Exception $e) {
            \Log::error('Chat fetchMessages error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new message
     */
    public function storeMessage(Request $request, Conversation $conversation)
    {
        try {
            $this->authorize($conversation);

            $validated = $request->validate([
                'body' => ['required', 'string', 'max:2000'],
            ]);

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'body' => $validated['body'],
            ]);

            $message->load('sender');

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'body' => $message->body,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->fname . ' ' . $message->sender->lname,
                    'created_at' => $message->created_at->format('H:i'),
                    'created_at_human' => $message->created_at->diffForHumans(),
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Chat storeMessage error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get list of conversations for current user (JSON API)
     */
    public function conversations()
    {
        try {
            $userId = Auth::id();

            $conversations = Conversation::where('user1_id', $userId)
                ->orWhere('user2_id', $userId)
                ->with(['user1', 'user2'])
                ->orderByDesc('updated_at')
                ->get()
                ->map(function($conv) use ($userId) {
                    $otherUser = $conv->user1_id === $userId ? $conv->user2 : $conv->user1;
                    return [
                        'id' => $conv->id,
                        'other_user_id' => $otherUser->id,
                        'other_user' => $otherUser->fname . ' ' . $otherUser->lname,
                        'updated_at' => $conv->updated_at->diffForHumans(),
                    ];
                })
                ->toArray();

            return response()->json([
                'success' => true,
                'conversations' => $conversations,
            ]);
        } catch (\Exception $e) {
            \Log::error('Chat conversations error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Authorize conversation access
     */
    private function authorize(Conversation $conversation)
    {
        $userId = Auth::id();

        if ($conversation->user1_id !== $userId && $conversation->user2_id !== $userId) {
            abort(403, 'Unauthorized access to conversation');
        }
    }
}

