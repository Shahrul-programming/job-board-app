<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class JobList extends Component
{
    public Collection $jobs;

    #[On('jobCreated')]
    public function handleJobCreated($jobId)
    {
        $this->jobs->add(Job::find($jobId));
    }

    #[On('jobUpdated')]
    public function handleJobUpdated()
    {
        $this->jobs = Job::all();
    }

    public function editJob($jobId)
    {
        $this->dispatch('editJob', $jobId);
    }

    public function mount()
    {
        $this->jobs = Job::all();
    }

    public function deleteJob($jobId)
    {
        $job = Job::find($jobId);
        if ($job) {
            $job->delete();
            $this->jobs = $this->jobs->filter(fn($j) => $j->id !== $jobId);
        }
    }

    public function render()
    {
        return view('livewire.job-list');
    }
}
