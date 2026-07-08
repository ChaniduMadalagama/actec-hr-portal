<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeLogResource extends JsonResource
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
            'jobId' => $this->job_id,
            'technicianId' => $this->technician_id,
            'checkInTime' => $this->check_in_time?->toIso8601String(),
            'checkOutTime' => $this->check_out_time?->toIso8601String(),
            'checkInLat' => $this->check_in_lat,
            'checkInLng' => $this->check_in_lng,
            'checkOutLat' => $this->check_out_lat,
            'checkOutLng' => $this->check_out_lng,
            'totalHours' => $this->total_hours,
            'deviceTamperFlag' => $this->device_tamper_flag,
            'job' => new JobResource($this->whenLoaded('job')),
            'technician' => new UserResource($this->whenLoaded('technician')),
            'createdAt' => $this->created_at?->toIso8601String(),
            'updatedAt' => $this->updated_at?->toIso8601String(),
        ];
    }
}
