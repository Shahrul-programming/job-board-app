<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database
        $this->seed();
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test user login functionality.
     */
    public function test_user_can_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'user@demo.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Test admin login functionality.
     */
    public function test_admin_can_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@demo.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard'); // Changed from /admin/dashboard to /dashboard
        $this->assertAuthenticated();
    }
}
