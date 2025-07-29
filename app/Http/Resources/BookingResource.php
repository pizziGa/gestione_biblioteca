<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'copy' => new CopyResource($this->whenLoaded('copy')),
            'queue' => $this->queue,
            'formatted_created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
