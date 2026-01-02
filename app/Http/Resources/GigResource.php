<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_gig,
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'photos' => $this->photos,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'handymen' => HandymanResource::collection($this->whenLoaded('handymen')),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
