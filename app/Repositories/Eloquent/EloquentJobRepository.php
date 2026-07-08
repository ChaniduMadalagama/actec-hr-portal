<?php

namespace App\Repositories\Eloquent;

use App\Models\Job;
use App\Repositories\Contracts\JobRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class EloquentJobRepository implements JobRepositoryInterface
{
    public function create(array $data): Job
    {
        return Job::create($data);
    }

    public function find(int $id): ?Job
    {
        return Job::find($id);
    }

    public function all(array $filters = []): Collection
    {
        $query = Job::query();

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['technician_id']) && $filters['technician_id'] !== '') {
            $query->where('assigned_to', $filters['technician_id']);
        }

        if (isset($filters['date']) && $filters['date'] !== '') {
            $date = Carbon::parse($filters['date']);
            $query->whereDate('scheduled_at', $date);
        }

        return $query->with(['technician'])->orderBy('scheduled_at', 'asc')->get();
    }

    public function getAssignedJobs(int $technicianId): Collection
    {
        return Job::where('assigned_to', $technicianId)
            ->whereIn('status', ['pending', 'in-route', 'in-progress'])
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    public function updateStatus(int $id, string $status): ?Job
    {
        $job = Job::find($id);
        if ($job) {
            $job->update(['status' => $status]);
        }
        return $job;
    }
}
