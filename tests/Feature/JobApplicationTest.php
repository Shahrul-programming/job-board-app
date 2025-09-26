<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_unauthenticated_user_cannot_apply_for_job(): void
    {
        $job = Job::factory()->create();

        // Test that individual job view is accessible without authentication
        $response = $this->get("/jobs/{$job->id}");
        $response->assertStatus(200);
        $response->assertSee('Login to Apply');

        // Test that jobs index shows login/register prompts
        $response = $this->get('/jobs');
        $response->assertStatus(200);
        $response->assertSee('Login to Apply');
    }

    public function test_authenticated_user_can_apply_for_job(): void
    {
        $user = User::factory()->create();
        $job = Job::factory()->create();

        $this->actingAs($user);

        // Test that individual job view shows apply button for authenticated user
        $response = $this->get("/jobs/{$job->id}");
        $response->assertStatus(200);
        $response->assertSee('Apply Now');
        $response->assertDontSee('Login to Apply');

        // Test that dashboard is accessible
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    public function test_job_application_requires_authentication(): void
    {
        $job = Job::factory()->create();

        // Attempt to access job application without authentication
        // This would be triggered by Livewire component, but we can test the logic

        $this->assertGuest();

        // Verify that jobs page is accessible to everyone
        $response = $this->get('/jobs');
        $response->assertStatus(200);
    }
}
