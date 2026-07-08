<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Job;
use App\Models\TimeLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class AcServiceApiTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the admin user for tests
        $this->adminUser = User::create([
            'name' => 'System Admin',
            'email' => 'admin@actec.com',
            'username' => 'admin',
            'password' => bcrypt('AdminPassword123'),
            'role' => 'admin',
            'current_status' => 'off_duty',
        ]);
    }

    /**
     * Test admin registers technician and returns credentials.
     */
    public function test_admin_can_register_technician_and_view_credentials(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->postJson('/api/v1/admin/users/register', [
                'name' => 'John Tech',
                'email' => 'john@actec.com',
                'username' => 'john_tech',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'username',
                'password',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'username',
                    'role',
                    'currentStatus',
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'username' => 'john_tech',
            'role' => 'technician',
            'current_status' => 'off_duty',
        ]);
    }

    /**
     * Test login and logout flow.
     */
    public function test_technician_can_login_and_logout(): void
    {
        $tech = User::create([
            'name' => 'John Tech',
            'email' => 'john@actec.com',
            'username' => 'john_tech',
            'password' => bcrypt('SecretTechPass123'),
            'role' => 'technician',
            'current_status' => 'off_duty',
        ]);

        // Login with correct credentials
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'username' => 'john_tech',
            'password' => 'SecretTechPass123',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user' => ['id', 'username', 'role']
            ]);

        $token = $loginResponse->json('token');

        // Logout using token
        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully.']);
    }

    /**
     * Test admin lists technicians.
     */
    public function test_admin_can_list_technicians(): void
    {
        User::create([
            'name' => 'Tech One',
            'email' => 'tech1@actec.com',
            'username' => 'tech1',
            'password' => bcrypt('pass'),
            'role' => 'technician',
            'current_status' => 'on_duty',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson('/api/v1/admin/users/technicians');

        $response->assertStatus(200)
            ->assertJsonCount(1);
    }

    /**
     * Test admin creates and lists jobs.
     */
    public function test_admin_can_create_and_filter_jobs(): void
    {
        $tech = User::create([
            'name' => 'Tech One',
            'email' => 'tech1@actec.com',
            'username' => 'tech1',
            'password' => bcrypt('pass'),
            'role' => 'technician',
            'current_status' => 'off_duty',
        ]);

        // Create job
        $createResponse = $this->actingAs($this->adminUser)
            ->postJson('/api/v1/admin/jobs', [
                'clientName' => 'Alice Client',
                'clientPhone' => '123-456-7890',
                'serviceAddress' => '123 AC Street, Cool City',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'issueDescription' => 'AC unit is blowing hot air.',
                'assignedTo' => $tech->id,
                'scheduledAt' => now()->addDay()->toIso8601String(),
            ]);

        $createResponse->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'clientName',
                'latitude',
                'longitude',
                'status',
            ]);

        // List jobs with filter
        $listResponse = $this->actingAs($this->adminUser)
            ->getJson('/api/v1/admin/jobs?status=pending&technicianId=' . $tech->id);

        $listResponse->assertStatus(200)
            ->assertJsonCount(1);
    }

    /**
     * Test technician job state machine and checks.
     */
    public function test_technician_job_lifecycle_and_checks(): void
    {
        $tech = User::create([
            'name' => 'Tech One',
            'email' => 'tech1@actec.com',
            'username' => 'tech1',
            'password' => bcrypt('pass'),
            'role' => 'technician',
            'current_status' => 'off_duty',
        ]);

        $job = Job::create([
            'client_name' => 'Alice Client',
            'client_phone' => '123-456-7890',
            'service_address' => '123 AC Street, Cool City',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'issue_description' => 'AC issue',
            'assigned_to' => $tech->id,
            'status' => 'pending',
            'scheduled_at' => now()->addHours(2),
        ]);

        // 1. Get assigned jobs
        $response = $this->actingAs($tech)
            ->getJson('/api/v1/tech/jobs/assigned');
        $response->assertStatus(200)->assertJsonCount(1);

        // 2. Start Route
        $response = $this->actingAs($tech)
            ->postJson("/api/v1/tech/jobs/{$job->id}/start-route");
        $response->assertStatus(200)
            ->assertJsonPath('status', 'in-route');

        $this->assertEquals('on_duty', $tech->fresh()->current_status);

        // 3. Check-in from far away (Failed location check)
        // Coordinates 41.7128, -74.0060 is > 100km away
        $response = $this->actingAs($tech)
            ->postJson("/api/v1/tech/jobs/{$job->id}/check-in", [
                'hardware_timestamp' => now()->toIso8601String(),
                'latitude' => 41.7128,
                'longitude' => -74.0060,
            ]);
        $response->assertStatus(400);
        $this->assertStringContainsString('Location Validation Failed: You must be on-site to check in.', $response->json('message'));

        // 4. Check-in close-by with normal clock (Success)
        // Coordinates 40.7130, -74.0062 is ~220m away from 40.7128, -74.0060
        $response = $this->actingAs($tech)
            ->postJson("/api/v1/tech/jobs/{$job->id}/check-in", [
                'hardware_timestamp' => now()->toIso8601String(),
                'latitude' => 40.7130,
                'longitude' => -74.0062,
            ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('time_logs', [
            'job_id' => $job->id,
            'technician_id' => $tech->id,
            'device_tamper_flag' => false,
        ]);
        $this->assertEquals('in-progress', $job->fresh()->status);

        // 5. Concurrency rule check: Create another job and try to check in
        $job2 = Job::create([
            'client_name' => 'Bob Client',
            'client_phone' => '123-456-7890',
            'service_address' => '456 Heat Street',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'issue_description' => 'Heater issue',
            'assigned_to' => $tech->id,
            'status' => 'pending',
            'scheduled_at' => now()->addHours(4),
        ]);

        $response = $this->actingAs($tech)
            ->postJson("/api/v1/tech/jobs/{$job2->id}/check-in", [
                'hardware_timestamp' => now()->toIso8601String(),
                'latitude' => 40.7128,
                'longitude' => -74.0060,
            ]);
        $response->assertStatus(400)
            ->assertJsonFragment(['message' => 'Concurrency Error: You are already checked into another job. Please check out first.']);

        // 6. Check-out far away (Failed location check)
        $response = $this->actingAs($tech)
            ->postJson("/api/v1/tech/jobs/{$job->id}/check-out", [
                'hardware_timestamp' => now()->toIso8601String(),
                'latitude' => 41.7128,
                'longitude' => -74.0060,
            ]);
        $response->assertStatus(400);

        // 7. Check-out close-by (Success)
        // Let's travel forward in time by 2 hours for billable calculations
        Carbon::setTestNow(now()->addHours(2));

        $response = $this->actingAs($tech)
            ->postJson("/api/v1/tech/jobs/{$job->id}/check-out", [
                'hardware_timestamp' => now()->toIso8601String(), // matched clock
                'latitude' => 40.7129,
                'longitude' => -74.0061,
            ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('time_logs', [
            'job_id' => $job->id,
            'total_hours' => 2.00,
        ]);
        $this->assertEquals('completed', $job->fresh()->status);
        $this->assertEquals('off_duty', $tech->fresh()->current_status);

        Carbon::setTestNow(); // reset time
    }

    /**
     * Test device clock tamper flag.
     */
    public function test_device_tamper_flag_activation(): void
    {
        $tech = User::create([
            'name' => 'Tech One',
            'email' => 'tech1@actec.com',
            'username' => 'tech1',
            'password' => bcrypt('pass'),
            'role' => 'technician',
            'current_status' => 'off_duty',
        ]);

        $job = Job::create([
            'client_name' => 'Alice Client',
            'client_phone' => '123-456-7890',
            'service_address' => '123 AC Street, Cool City',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'issue_description' => 'AC issue',
            'assigned_to' => $tech->id,
            'status' => 'pending',
            'scheduled_at' => now()->addHours(2),
        ]);

        // Post check-in with a hardware timestamp 10 minutes (600s) off compared to server time
        $response = $this->actingAs($tech)
            ->postJson("/api/v1/tech/jobs/{$job->id}/check-in", [
                'hardware_timestamp' => now()->subMinutes(10)->toIso8601String(),
                'latitude' => 40.7128,
                'longitude' => -74.0060,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('time_logs', [
            'job_id' => $job->id,
            'device_tamper_flag' => true,
        ]);
    }
}
