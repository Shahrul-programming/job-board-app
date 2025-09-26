<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class JobEdit extends Component
{
    public $jobId;

    public $title;

    public $company;

    public $location;

    public $description;

    public $showModal = false;

    #[On('editJob')]
    public function openEditModal($jobId)
    {
        $this->jobId = $jobId;
        $job = \App\Models\Job::find($jobId);
        if ($job) {
            $this->title = $job->title;
            $this->company = $job->company;
            $this->location = $job->location;
            $this->description = $job->description;
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['jobId', 'title', 'company', 'location', 'description']);
    }

    public function update()
    {
        // Check if user can edit jobs using policy
        if (! auth()->user()->can('editJobs', auth()->user())) {
            abort(403, 'Unauthorized. Only administrators can edit jobs.');
        }

        $this->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $job = \App\Models\Job::find($this->jobId);
        if ($job) {
            $job->update([
                'title' => $this->title,
                'company' => $this->company,
                'location' => $this->location,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Job updated successfully!');
        }

        $this->dispatch('jobUpdated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.job-edit');
    }
}
