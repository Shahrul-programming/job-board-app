<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class JobList extends Component
{
    public Collection $jobs;
    public $currentSearch = '';

    #[On('jobCreated')]
    public function handleJobCreated($jobId)
    {
        $this->refreshJobs();
    }

    #[On('jobUpdated')]
    public function handleJobUpdated()
    {
        $this->refreshJobs();
    }

    public function viewJob($jobId)
    {
        $this->dispatch('jobViewed', $jobId);
    }

    public function editJob($jobId)
    {
        $this->dispatch('editJob', $jobId);
    }

    public function mount()
    {
        $this->refreshJobs();
    }

    public function deleteJob($jobId)
    {
        $job = Job::find($jobId);
        if ($job) {
            $job->delete();
            $this->jobs = $this->jobs->filter(fn($j) => $j->id !== $jobId);
        }
    }

    #[On('searchUpdated')]
    public function handleSearchUpdated($search)
    {
        $this->currentSearch = $search;
        $this->refreshJobs();
    }

    protected function refreshJobs()
    {
        if (empty($this->currentSearch)) {
            $this->jobs = Job::latest()->get();
        } else {
            $this->jobs = Job::where('title', 'like', '%' . $this->currentSearch . '%')
                ->orWhere('company', 'like', '%' . $this->currentSearch . '%')
                ->orWhere('location', 'like', '%' . $this->currentSearch . '%')
                ->latest()
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.job-list');
    }
}
