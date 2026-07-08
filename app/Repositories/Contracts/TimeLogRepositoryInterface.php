<?php

namespace App\Repositories\Contracts;

use App\Models\TimeLog;
use Illuminate\Database\Eloquent\Collection;

interface TimeLogRepositoryInterface
{
    public function createCheckIn(int $jobId, int $technicianId, array $data): TimeLog;
    public function updateCheckOut(int $jobId, int $technicianId, array $data): ?TimeLog;
    public function hasActiveLog(int $technicianId): bool;
    public function getActiveLogForJob(int $jobId, int $technicianId): ?TimeLog;
    public function all(): Collection;
}
