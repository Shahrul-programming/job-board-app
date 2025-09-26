<?php

namespace Database\Seeders;

use App\Models\Job;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo users first
        User::firstOrCreate([
            'email' => 'admin@demo.com',
        ], [
            'name' => 'Admin User',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        User::firstOrCreate([
            'email' => 'user@demo.com',
        ], [
            'name' => 'Regular User',
            'role' => 'guest',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        // Create additional fake users
        User::factory(10)->create();

        // Create jobs
        Job::factory(50)->create();

        // Seed job applications
        $this->call([
            JobApplicationSeeder::class,
        ]);
    }
}
