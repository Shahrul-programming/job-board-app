<?php

namespace App\Livewire\Admin;

use App\Models\Job;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class AdminJobCreate extends Component
{
    public $title = '';

    public $company = '';

    public $location = '';

    public $description = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
    ];

    protected $messages = [
        'title.required' => 'Job title is required.',
        'company.required' => 'Company name is required.',
        'location.required' => 'Location is required.',
        'description.required' => 'Description is required.',
        'description.max' => 'Description should not exceed 1000 characters.',
    ];

    public function save()
    {
        // Check if user is authenticated and admin
        if (! auth()->check() || ! Gate::allows('isAdmin', auth()->user())) {
            abort(403, 'Unauthorized. Only administrators can create jobs.');
        }

        $this->validate();

        try {
            Job::create([
                'title' => $this->title,
                'company' => $this->company,
                'location' => $this->location,
                'description' => $this->description,
            ]);

            // Clear form
            $this->reset(['title', 'company', 'location', 'description']);

            // Dispatch event to refresh job lists
            $this->dispatch('jobCreated');

            // Show success message
            session()->flash('success', 'Job created successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating job: '.$e->getMessage());
        }
    }

    public function clear()
    {
        $this->reset(['title', 'company', 'location', 'description']);
    }

    public function render()
    {
        return view('livewire.admin.admin-job-create');
    }
}
