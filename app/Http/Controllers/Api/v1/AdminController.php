<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\Repositories\Contracts\TimeLogRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Http\Resources\JobResource;
use App\Http\Resources\TimeLogResource;

class AdminController extends Controller
{
    protected UserRepositoryInterface $userRepository;
    protected JobRepositoryInterface $jobRepository;
    protected TimeLogRepositoryInterface $timeLogRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        JobRepositoryInterface $jobRepository,
        TimeLogRepositoryInterface $timeLogRepository
    ) {
        $this->userRepository = $userRepository;
        $this->jobRepository = $jobRepository;
        $this->timeLogRepository = $timeLogRepository;
    }

    /**
     * Register a new technician.
     * System auto-generates a secure password and returns plain text credentials.
     */
    public function registerTechnician(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
        ]);

        $plainPassword = Str::random(12);

        $user = $this->userRepository->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($plainPassword),
            'role' => 'technician',
            'current_status' => 'off_duty',
        ]);

        return response()->json([
            'message' => 'Technician registered successfully.',
            'username' => $user->username,
            'password' => $plainPassword,
            'user' => new UserResource($user),
        ], 201);
    }

    /**
     * List all technicians with their live status.
     */
    public function listTechnicians()
    {
        $technicians = $this->userRepository->getTechniciansWithLiveStatus();
        return UserResource::collection($technicians);
    }

    /**
     * Create a new repair job.
     */
    public function createJob(Request $request)
    {
        $validated = $request->validate([
            'clientName' => 'required|string|max:255',
            'clientPhone' => 'required|string|max:20',
            'serviceAddress' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'issueDescription' => 'required|string',
            'assignedTo' => 'nullable|exists:users,id',
            'scheduledAt' => 'required|date',
        ]);

        // Convert key names from camelCase (API request payload) to snake_case (DB columns)
        $job = $this->jobRepository->create([
            'client_name' => $validated['clientName'],
            'client_phone' => $validated['clientPhone'],
            'service_address' => $validated['serviceAddress'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'issue_description' => $validated['issueDescription'],
            'assigned_to' => $validated['assignedTo'] ?? null,
            'scheduled_at' => $validated['scheduledAt'],
            'status' => 'pending',
        ]);

        $job->load('technician');

        return response()->json(new JobResource($job), 201);
    }

    /**
     * Get all jobs with filtering options (status, date, technician).
     */
    public function listJobs(Request $request)
    {
        $filters = [
            'status' => $request->query('status'),
            'date' => $request->query('date'),
            'technician_id' => $request->query('technicianId'), // Accept camelCase query param
        ];

        $jobs = $this->jobRepository->all($filters);
        return JobResource::collection($jobs);
    }

    /**
     * Get all time logs showing check-in/out times, duration, and matching coordinates.
     */
    public function listTimeTrackingLogs()
    {
        $logs = $this->timeLogRepository->all();
        return TimeLogResource::collection($logs);
    }

    /**
     * Reset technician password.
     */
    public function resetTechnicianPassword($id)
    {
        $user = $this->userRepository->find($id);
        if (!$user || $user->role !== 'technician') {
            return response()->json(['message' => 'Technician not found.'], 404);
        }

        $plainPassword = Str::random(12);
        $user->password = Hash::make($plainPassword);
        $user->save();

        return response()->json([
            'message' => 'Password reset successfully.',
            'username' => $user->username,
            'password' => $plainPassword,
        ], 200);
    }
}

