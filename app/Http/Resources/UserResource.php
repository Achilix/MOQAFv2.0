<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'full_name' => $this->fname . ' ' . $this->lname,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'city' => $this->city,
            'photo' => $this->photo,
            'is_handyman' => $this->handyman !== null,
            'is_client' => $this->client !== null,
            'handyman' => new HandymanResource($this->whenLoaded('handyman')),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
