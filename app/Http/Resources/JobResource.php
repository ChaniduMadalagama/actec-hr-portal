<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'clientName' => $this->client_name,
            'clientPhone' => $this->client_phone,
            'serviceAddress' => $this->service_address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'issueDescription' => $this->issue_description,
            'status' => $this->status,
            'assignedTo' => $this->assigned_to,
            'scheduledAt' => $this->scheduled_at?->toIso8601String(),
            'technician' => new UserResource($this->whenLoaded('technician')),
            'timeLogs' => TimeLogResource::collection($this->whenLoaded('timeLogs')),
            'createdAt' => $this->created_at?->toIso8601String(),
            'updatedAt' => $this->updated_at?->toIso8601String(),
        ];
    }
}
