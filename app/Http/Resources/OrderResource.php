<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->order_id,
            'budget' => (float) $this->budget,
            'description' => $this->description,
            'status' => $this->status,
            'rating' => $this->rating ? (float) $this->rating : null,
            'client' => new UserResource($this->whenLoaded('client')),
            'handyman' => new HandymanResource($this->whenLoaded('handyman')),
            'gig' => new GigResource($this->whenLoaded('gig')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
