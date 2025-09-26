<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $users = \App\Models\User::all();

        if ($jobs->isEmpty() || $users->isEmpty()) {
            return;
        }

        $sampleApplications = [
            [
                'full_name' => 'Ahmad bin Abdullah',
                'email' => 'ahmad@example.com',
                'phone_number' => '+60123456789',
                'why_interested' => 'I am very interested in this position because I have 3 years of experience in web development and I believe my skills would be a great fit for your company.',
                'expected_salary' => 'RM 4500',
                'available_start_date' => now()->addDays(30),
                'willing_to_relocate' => true,
            ],
            [
                'full_name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'phone_number' => '+60198765432',
                'why_interested' => 'As a fresh graduate with a degree in Computer Science, I am eager to start my career in software development. This position aligns perfectly with my skills and interests.',
                'expected_salary' => 'RM 3500',
                'available_start_date' => now()->addDays(14),
                'willing_to_relocate' => false,
            ],
            [
                'full_name' => 'Muhammad Faiz',
                'email' => 'faiz@example.com',
                'phone_number' => '+60145678901',
                'why_interested' => 'I have been following your company\'s growth and I am impressed by your innovative projects. I would love to contribute my expertise in mobile app development.',
                'expected_salary' => 'RM 5500',
                'available_start_date' => now()->addDays(21),
                'willing_to_relocate' => true,
            ],
            [
                'full_name' => 'Nurul Ain',
                'email' => 'nurul@example.com',
                'phone_number' => '+60123409876',
                'why_interested' => 'With my background in UI/UX design and 2 years of experience, I am confident that I can help improve the user experience of your applications.',
                'expected_salary' => 'RM 4000',
                'available_start_date' => now()->addDays(7),
                'willing_to_relocate' => false,
            ],
            [
                'full_name' => 'Hafiz Rahman',
                'email' => 'hafiz@example.com',
                'phone_number' => '+60187654321',
                'why_interested' => 'I am passionate about data analysis and have strong skills in Python and SQL. I believe I can help your team make data-driven decisions.',
                'expected_salary' => 'RM 5000',
                'available_start_date' => now()->addDays(45),
                'willing_to_relocate' => true,
            ],
        ];

        foreach ($sampleApplications as $application) {
            JobApplication::create([
                'job_id' => $jobs->random()->id,
                'user_id' => $users->random()->id, // Assign a random user
                'status' => 'pending', // Set default status
                ...$application,
            ]);
        }
    }
}
