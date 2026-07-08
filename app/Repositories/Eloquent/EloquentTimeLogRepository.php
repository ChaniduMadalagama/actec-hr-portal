<?php

namespace App\Repositories\Eloquent;

use App\Models\TimeLog;
use App\Repositories\Contracts\TimeLogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentTimeLogRepository implements TimeLogRepositoryInterface
{
    public function createCheckIn(int $jobId, int $technicianId, array $data): TimeLog
    {
        return TimeLog::create(array_merge([
            'job_id' => $jobId,
            'technician_id' => $technicianId,
        ], $data));
    }

    public function updateCheckOut(int $jobId, int $technicianId, array $data): ?TimeLog
    {
        $log = $this->getActiveLogForJob($jobId, $technicianId);
        if ($log) {
            $log->update($data);
        }
        return $log;
    }

    public function hasActiveLog(int $technicianId): bool
    {
        return TimeLog::where('technician_id', $technicianId)
            ->whereNull('check_out_time')
            ->exists();
    }

    public function getActiveLogForJob(int $jobId, int $technicianId): ?TimeLog
    {
        return TimeLog::where('job_id', $jobId)
            ->where('technician_id', $technicianId)
            ->whereNull('check_out_time')
            ->first();
    }

    public function all(): Collection
    {
        return TimeLog::with(['job', 'technician'])->orderBy('created_at', 'desc')->get();
    }
}
