<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HandymanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->handyman_id,
            'services' => $this->services,
            'bio' => $this->bio,
            'user' => new UserResource($this->whenLoaded('user')),
            'average_rating' => $this->when(
                $this->relationLoaded('reviews'),
                round($this->reviews->avg('rating'), 2)
            ),
            'review_count' => $this->when(
                $this->relationLoaded('reviews'),
                $this->reviews->count()
            ),
            'completed_jobs' => $this->completed_jobs_count,
        ];
    }
}
