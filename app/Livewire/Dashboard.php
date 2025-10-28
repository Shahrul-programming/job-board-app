<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Dashboard extends Component
{
    // Properties for inline job creation
    public $newJobTitle = '';

    public $newJobCompany = '';

    public $newJobLocation = '';

    public $newJobDescription = '';

    protected $rules = [
        'newJobTitle' => 'required|string|max:255',
        'newJobCompany' => 'required|string|max:255',
        'newJobLocation' => 'required|string|max:255',
        'newJobDescription' => 'required|string',
    ];

    protected $messages = [
        'newJobTitle.required' => 'Job title is required.',
        'newJobCompany.required' => 'Company name is required.',
        'newJobLocation.required' => 'Job location is required.',
        'newJobDescription.required' => 'Job description is required.',
    ];

    public function createJob()
    {
        // Check if user is authenticated
        if (! auth()->check()) {
            abort(401, 'Unauthorized. Please login first.');
        }

        // Check if user can create jobs
        if (! auth()->user()->can('createJobs', auth()->user())) {
            abort(403, 'Unauthorized. Only administrators can create jobs.');
        }

        $this->validate();

        try {
            // Create the job with pending status
            Job::create([
                'title' => $this->newJobTitle,
                'company' => $this->newJobCompany,
                'location' => $this->newJobLocation,
                'description' => $this->newJobDescription,
                'status' => 'pending', // Jobs must be paid to be activated
                'user_id' => auth()->id(),
            ]);

            // Clear the form
            $this->reset(['newJobTitle', 'newJobCompany', 'newJobLocation', 'newJobDescription']);

            // Dispatch event to refresh job list
            $this->dispatch('jobCreated');

            // Show success message
            session()->flash('message', 'Job created successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating job: '.$e->getMessage());
        }
    }

    public function render()
    {
        $user = auth()->user();

        // If no user is authenticated, redirect to login
        if (! $user) {
            return redirect()->route('login');
        }

        // Get jobs data - only count ACTIVE jobs for public display
        $totalJobs = Job::where('status', 'active')->count();

        // Admin-specific data
        $adminData = [];
        if (Gate::allows('isAdmin', $user)) {
            $adminData = [
                'totalApplications' => JobApplication::count(),
                'pendingApplications' => JobApplication::where('status', 'pending')->count(),
                'recentApplications' => JobApplication::with(['job', 'user'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'totalUsers' => User::count(),
                'totalJobsAll' => Job::count(), // All jobs including pending
                'pendingJobs' => Job::where('status', 'pending')->count(),
                'activeJobs' => Job::where('status', 'active')->count(),
            ];
        }

        // Guest-specific data (applications made by this user)
        $guestData = [];
        if (Gate::denies('isAdmin', $user)) {
            $guestData = [
                'myApplications' => JobApplication::where('user_id', $user->id)
                    ->with('job')
                    ->latest()
                    ->take(5)
                    ->get(),
                'myApplicationsCount' => JobApplication::where('user_id', $user->id)->count(),
            ];
        }

        return view('livewire.dashboard', compact('totalJobs', 'adminData', 'guestData', 'user'));
    }
}
