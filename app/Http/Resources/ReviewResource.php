<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->review_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'response' => $this->response,
            'response_at' => $this->response_at?->toISOString(),
            'client' => new UserResource($this->whenLoaded('client')),
            'handyman' => new HandymanResource($this->whenLoaded('handyman')),
            'order_id' => $this->order_id,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
