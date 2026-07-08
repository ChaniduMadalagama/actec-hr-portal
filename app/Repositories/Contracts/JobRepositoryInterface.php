<?php

namespace App\Repositories\Contracts;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;

interface JobRepositoryInterface
{
    public function create(array $data): Job;
    public function find(int $id): ?Job;
    public function all(array $filters = []): Collection;
    public function getAssignedJobs(int $technicianId): Collection;
    public function updateStatus(int $id, string $status): ?Job;
}
