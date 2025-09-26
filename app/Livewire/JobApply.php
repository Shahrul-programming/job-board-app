<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\JobApplication;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class JobApply extends Component
{
    use WithFileUploads;

    public $showModal = false;

    public ?Job $job = null;

    // Personal Information
    #[Validate('required|string|max:255')]
    public $full_name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('required|string|max:20')]
    public $phone_number = '';

    // Professional Information
    #[Validate('required|file|mimes:pdf,doc,docx|max:10240')]
    public $resume;

    #[Validate('nullable|string|max:2000')]
    public $cover_letter = '';

    #[Validate('nullable|file|mimes:pdf,doc,docx|max:10240')]
    public $cover_letter_path;

    #[Validate('nullable|url|max:255')]
    public $linkedin_url = '';

    #[Validate('nullable|url|max:255')]
    public $portfolio_url = '';

    // Application-specific
    #[Validate('required|string|max:1000')]
    public $why_interested = '';

    #[Validate('nullable|string|max:100')]
    public $expected_salary = '';

    #[Validate('required|date|after:today')]
    public $available_start_date = '';

    public $willing_to_relocate = false;

    #[On('apply-for-job')]
    public function applyForJob($jobId)
    {
        // Check if user is authenticated
        if (! auth()->check()) {
            session()->flash('error', 'You must be logged in to apply for jobs. Please login or register first.');
            $this->dispatch('redirectToLogin');

            return;
        }

        $this->job = Job::find($jobId);
        $this->showModal = true;
        $this->resetForm();

        // Pre-fill form with authenticated user data
        if (auth()->check()) {
            $user = auth()->user();
            $this->full_name = $user->name;
            $this->email = $user->email;
        }

        // Close the job-view modal
        $this->dispatch('closeJobView');
    }

    public function submitApplication()
    {
        // Double-check authentication
        if (! auth()->check()) {
            session()->flash('error', 'You must be logged in to apply for jobs.');
            $this->dispatch('redirectToLogin');

            return;
        }

        $this->validate();

        try {
            // Store resume file
            $resumePath = $this->resume->store('resumes', 'public');

            // Store cover letter file if provided
            $coverLetterPath = null;
            if ($this->cover_letter_path) {
                $coverLetterPath = $this->cover_letter_path->store('cover-letters', 'public');
            }

            // Create the job application with authenticated user
            JobApplication::create([
                'job_id' => $this->job->id,
                'user_id' => auth()->id(), // Link to authenticated user
                'full_name' => $this->full_name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'resume_path' => $resumePath,
                'cover_letter' => $this->cover_letter,
                'cover_letter_path' => $coverLetterPath,
                'linkedin_url' => $this->linkedin_url,
                'portfolio_url' => $this->portfolio_url,
                'why_interested' => $this->why_interested,
                'expected_salary' => $this->expected_salary,
                'available_start_date' => $this->available_start_date,
                'willing_to_relocate' => $this->willing_to_relocate,
                'status' => 'pending', // Set default status
            ]);

            $this->dispatch('applicationSubmitted');

            // Close without reopening job-view after successful submission
            $this->showModal = false;
            $this->job = null;
            $this->resetForm();
            $this->resetValidation();

            session()->flash('message', 'Your application has been submitted successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'There was an error submitting your application. Please try again.');
        }
    }

    public function closeModal()
    {
        $jobId = $this->job?->id; // Store job ID before resetting
        $this->showModal = false;
        $this->job = null;
        $this->resetForm();
        $this->resetValidation();

        // Reopen the job-view modal if we have a job ID
        if ($jobId) {
            $this->dispatch('jobViewed', $jobId);
        }
    }

    public function render()
    {
        return view('livewire.job-apply');
    }

    public function resetForm()
    {
        $this->full_name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->resume = null;
        $this->cover_letter = '';
        $this->cover_letter_path = null;
        $this->linkedin_url = '';
        $this->portfolio_url = '';
        $this->why_interested = '';
        $this->expected_salary = '';
        $this->available_start_date = '';
        $this->willing_to_relocate = false;
    }
}
