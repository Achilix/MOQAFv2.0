<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user1_id' => $this->user1_id,
            'user2_id' => $this->user2_id,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'user1' => new UserResource($this->whenLoaded('user1')),
            'user2' => new UserResource($this->whenLoaded('user2')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
            'last_message' => new MessageResource($this->whenLoaded('messages', function () {
                return $this->messages->first();
            })),
        ];
    }
}
