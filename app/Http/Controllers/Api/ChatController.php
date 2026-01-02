<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;

class ChatController extends Controller
{
    public function startConversation(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id|different:user_id',
        ]);

        $user = $request->user();

        // Check if conversation already exists
        $conversation = Conversation::where(function ($query) use ($user, $validated) {
            $query->where('user1_id', $user->id)
                  ->where('user2_id', $validated['recipient_id']);
        })->orWhere(function ($query) use ($user, $validated) {
            $query->where('user1_id', $validated['recipient_id'])
                  ->where('user2_id', $user->id);
        })->first();

        if ($conversation) {
            return response()->json([
                'message' => 'Conversation already exists',
                'data' => new ConversationResource($conversation->load(['messages', 'user1', 'user2'])),
            ]);
        }

        $conversation = Conversation::create([
            'user1_id' => $user->id,
            'user2_id' => $validated['recipient_id'],
        ]);

        return response()->json([
            'message' => 'Conversation started',
            'data' => new ConversationResource($conversation->load(['user1', 'user2'])),
        ], 201);
    }

    public function getConversations(Request $request)
    {
        $user = $request->user();

        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2', 'messages' => function ($query) {
                $query->latest()->take(1);
            }])
            ->latest('updated_at')
            ->paginate(20);

        return response()->json([
            'data' => ConversationResource::collection($conversations->items()),
            'pagination' => [
                'total' => $conversations->total(),
                'per_page' => $conversations->perPage(),
                'current_page' => $conversations->currentPage(),
                'last_page' => $conversations->lastPage(),
            ],
        ]);
    }

    public function getConversation(Request $request, $id)
    {
        $user = $request->user();
        $conversation = Conversation::findOrFail($id);

        // Check authorization
        if ($conversation->user1_id !== $user->id && $conversation->user2_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $conversation->load(['user1', 'user2', 'messages' => function ($query) {
            $query->with('sender')->latest();
        }]);

        return response()->json([
            'data' => new ConversationResource($conversation),
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        $user = $request->user();
        $conversation = Conversation::findOrFail($id);

        // Check authorization
        if ($conversation->user1_id !== $user->id && $conversation->user2_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->touch();

        return response()->json([
            'message' => 'Message sent',
            'data' => new MessageResource($message->load('sender')),
        ], 201);
    }

    public function getMessages(Request $request, $id)
    {
        $user = $request->user();
        $conversation = Conversation::findOrFail($id);

        // Check authorization
        if ($conversation->user1_id !== $user->id && $conversation->user2_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->paginate(30);

        return response()->json([
            'data' => MessageResource::collection($messages->items()),
            'pagination' => [
                'total' => $messages->total(),
                'per_page' => $messages->perPage(),
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
            ],
        ]);
    }
}
