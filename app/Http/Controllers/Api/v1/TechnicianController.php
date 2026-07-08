<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\Repositories\Contracts\TimeLogRepositoryInterface;
use App\Http\Resources\JobResource;
use App\Http\Resources\TimeLogResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TechnicianController extends Controller
{
    protected JobRepositoryInterface $jobRepository;
    protected TimeLogRepositoryInterface $timeLogRepository;

    public function __construct(
        JobRepositoryInterface $jobRepository,
        TimeLogRepositoryInterface $timeLogRepository
    ) {
        $this->jobRepository = $jobRepository;
        $this->timeLogRepository = $timeLogRepository;
    }

    /**
     * List all active and scheduled jobs assigned to the authenticated technician.
     */
    public function assignedJobs(Request $request)
    {
        $technicianId = $request->user()->id;
        $jobs = $this->jobRepository->getAssignedJobs($technicianId);
        return JobResource::collection($jobs);
    }

    /**
     * Detailed view of a specific job.
     */
    public function jobDetails(Request $request, $id)
    {
        $job = $this->jobRepository->find($id);

        if (!$job) {
            return response()->json([
                'message' => 'Job not found.'
            ], 404);
        }

        // Authorize that the job belongs to this technician
        if ($job->assigned_to !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden: This job is not assigned to you.'
            ], 403);
        }

        $job->load(['technician', 'timeLogs']);

        return new JobResource($job);
    }

    /**
     * Transition job status to 'in-route' when technician starts traveling.
     */
    public function startRoute(Request $request, $id)
    {
        $job = $this->jobRepository->find($id);

        if (!$job) {
            return response()->json([
                'message' => 'Job not found.'
            ], 404);
        }

        if ($job->assigned_to !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden: This job is not assigned to you.'
            ], 403);
        }

        if ($job->status !== 'pending') {
            return response()->json([
                'message' => 'Job route cannot be started because it is already ' . $job->status . '.'
            ], 400);
        }

        $job = $this->jobRepository->updateStatus($id, 'in-route');
        
        // Update tech live status
        $user = $request->user();
        $user->update(['current_status' => 'on_duty']);

        return new JobResource($job);
    }

    /**
     * Check in to a job.
     */
    public function checkIn(Request $request, $id)
    {
        $job = $this->jobRepository->find($id);

        if (!$job) {
            return response()->json([
                'message' => 'Job not found.'
            ], 404);
        }

        if ($job->assigned_to !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden: This job is not assigned to you.'
            ], 403);
        }

        // Concurrency rule: check if technician has an active open log
        if ($this->timeLogRepository->hasActiveLog($request->user()->id)) {
            return response()->json([
                'message' => 'Concurrency Error: You are already checked into another job. Please check out first.'
            ], 400);
        }

        $validated = $request->validate([
            'hardware_timestamp' => 'required',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        // Location check: Haversine distance from job location
        $distance = $this->calculateDistance(
            (float) $validated['latitude'],
            (float) $validated['longitude'],
            (float) $job->latitude,
            (float) $job->longitude
        );

        $maxDistance = (float) env('MAX_ON_SITE_DISTANCE_METERS', 500.0);
        if ($distance > $maxDistance) {
            return response()->json([
                'message' => "Location Validation Failed: You must be on-site to check in. (Current distance: " . round($distance, 1) . "m, Limit: {$maxDistance}m)"
            ], 400);
        }

        // Tamper flag detection
        $serverTime = Carbon::now();
        $deviceTime = Carbon::parse($validated['hardware_timestamp']);
        $variance = abs($serverTime->diffInSeconds($deviceTime));
        $tamperFlag = $variance > 300; // 5 minutes variance

        // Create check-in log
        $timeLog = $this->timeLogRepository->createCheckIn($job->id, $request->user()->id, [
            'check_in_time' => $serverTime,
            'check_in_lat' => $validated['latitude'],
            'check_in_lng' => $validated['longitude'],
            'device_tamper_flag' => $tamperFlag,
        ]);

        // Update Job state to in-progress
        $this->jobRepository->updateStatus($job->id, 'in-progress');

        // Ensure tech is marked as on_duty
        $request->user()->update(['current_status' => 'on_duty']);

        return response()->json([
            'message' => 'Checked in successfully.',
            'timeLog' => new TimeLogResource($timeLog),
        ], 200);
    }

    /**
     * Check out from a job.
     */
    public function checkOut(Request $request, $id)
    {
        $job = $this->jobRepository->find($id);

        if (!$job) {
            return response()->json([
                'message' => 'Job not found.'
            ], 404);
        }

        if ($job->assigned_to !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden: This job is not assigned to you.'
            ], 403);
        }

        // Ensure there is an active log for this job
        $timeLog = $this->timeLogRepository->getActiveLogForJob($job->id, $request->user()->id);
        if (!$timeLog) {
            return response()->json([
                'message' => 'State Error: No active check-in session found for this job.'
            ], 400);
        }

        $validated = $request->validate([
            'hardware_timestamp' => 'required',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        // Location check: Haversine distance from job location
        $distance = $this->calculateDistance(
            (float) $validated['latitude'],
            (float) $validated['longitude'],
            (float) $job->latitude,
            (float) $job->longitude
        );

        $maxDistance = (float) env('MAX_ON_SITE_DISTANCE_METERS', 500.0);
        if ($distance > $maxDistance) {
            return response()->json([
                'message' => "Location Validation Failed: You must be on-site to check out. (Current distance: " . round($distance, 1) . "m, Limit: {$maxDistance}m)"
            ], 400);
        }

        // Tamper flag detection
        $serverTime = Carbon::now();
        $deviceTime = Carbon::parse($validated['hardware_timestamp']);
        $variance = abs($serverTime->diffInSeconds($deviceTime));
        $tamperFlag = $timeLog->device_tamper_flag || ($variance > 300); // retain tamper if flagged on check-in or checkout

        // Calculate billable total hours
        $checkInTime = Carbon::parse($timeLog->check_in_time);
        $totalHours = round($checkInTime->diffInMinutes($serverTime) / 60, 2);

        // Update checkout details
        $timeLog = $this->timeLogRepository->updateCheckOut($job->id, $request->user()->id, [
            'check_out_time' => $serverTime,
            'check_out_lat' => $validated['latitude'],
            'check_out_lng' => $validated['longitude'],
            'total_hours' => $totalHours,
            'device_tamper_flag' => $tamperFlag,
        ]);

        // Update Job state to completed
        $this->jobRepository->updateStatus($job->id, 'completed');

        // Reset technician's live duty status to off_duty
        $request->user()->update(['current_status' => 'off_duty']);

        return response()->json([
            'message' => 'Checked out successfully.',
            'timeLog' => new TimeLogResource($timeLog->fresh()),
        ], 200);
    }

    /**
     * Compute distance between two coordinates in meters (Haversine formula).
     */
    private function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000; // in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lngDelta / 2) * sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
