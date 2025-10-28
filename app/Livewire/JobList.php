<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class JobList extends Component
{
    public Collection $jobs;
    public $currentSearch = '';
    public $perPage = 5;
    public $hasMore = true;
    public $loading = false;
    public $totalJobs = 0;

    #[On('jobCreated')]
    public function handleJobCreated($jobId = null)
    {
        $this->resetJobs();
    }

    #[On('jobUpdated')]
    public function handleJobUpdated()
    {
        $this->resetJobs();
    }

    public function viewJob($jobId)
    {
        return redirect()->route('jobs.show', $jobId);
    }

    public function editJob($jobId)
    {
        return redirect()->route('jobs.edit', $jobId);
    }

    public function mount()
    {
        $this->jobs = collect();
        $this->loadMoreJobs();
    }

    public function deleteJob($jobId)
    {
        if (! auth()->user()->can('deleteJobs', auth()->user())) {
            abort(403, 'Unauthorized. Only administrators can delete jobs.');
        }

        $job = Job::find($jobId);
        if ($job) {
            $job->delete();
            $this->jobs = $this->jobs->reject(fn ($j) => $j->id == $jobId);
        }
    }

    public function createJob()
    {
        return redirect()->to('/jobs/create');
    }

    #[On('searchUpdated')]
    public function handleSearchUpdated($search)
    {
        $this->currentSearch = $search;
        $this->resetJobs();
    }

    public function loadMoreJobs()
    {
        if (! $this->hasMore || $this->loading) {
            return;
        }

        $this->loading = true;
        sleep(1);

        $currentCount = $this->jobs->count();
        $query = Job::where('status', 'active');

        if (! empty($this->currentSearch)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->currentSearch.'%')
                    ->orWhere('company', 'like', '%'.$this->currentSearch.'%')
                    ->orWhere('location', 'like', '%'.$this->currentSearch.'%')
                    ->orWhere('description', 'like', '%'.$this->currentSearch.'%');        
            });
        }

        $this->totalJobs = $query->count();

        $newJobs = $query->latest()
            ->skip($currentCount)
            ->take($this->perPage)
            ->get();

        $this->jobs = $this->jobs->merge($newJobs);
        $this->hasMore = $this->jobs->count() < $this->totalJobs;
        $this->loading = false;
    }

    protected function resetJobs()
    {
        $this->jobs = collect();
        $this->hasMore = true;
        $this->loadMoreJobs();
    }

    protected function refreshJobs()
    {
        $this->resetJobs();
    }

    public function render()
    {
        return view('livewire.job-list');
    }
}
