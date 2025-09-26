<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;

class JobCreate extends Component
{
    public $title;

    public $company;

    public $location;

    public $description;

    public function save()
    {
        // Check if user can create jobs using policy
        if (! auth()->user()->can('createJobs', auth()->user())) {
            abort(403, 'Unauthorized. Only administrators can create jobs.');
        }

        $this->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $job = Job::create([
            'title' => $this->title,
            'company' => $this->company,
            'location' => $this->location,
            'description' => $this->description,
        ]);

        $this->dispatch('jobCreated', $job->id);

        $this->clear();

        session()->flash('success', 'Job created successfully!');
    }

    public function clear()
    {
        $this->title = '';
        $this->company = '';
        $this->location = '';
    }

    public function render()
    {
        return view('livewire.job-create');
    }
}
