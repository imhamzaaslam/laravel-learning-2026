<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'uuid' => $this->uuid,
            'title' => $this->title,
            'user' => $this->user,
            'description' => $this->description,
            'due_date' => $this->due_date?->format("d-M-Y"),
            'created_at' => $this->created_at->format("d-M-Y h:i A"),
            'estimated_time' => $this->estimated_time,
        ];
    }
}
