<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Attributes\On;
use Livewire\Component;

class JobView extends Component
{
    public ?Job $job = null;

    public bool $showModal = false;

    #[On('jobViewed')]
    public function viewJob($jobId)
    {
        $this->job = Job::find($jobId);
        $this->showModal = true;
    }

    #[On('closeJobView')]
    public function closeJobView()
    {
        $this->closeModal();
    }

    public function applyForJob($jobId)
    {
        $this->dispatch('apply-for-job', $jobId);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->job = null;
    }

    public function render()
    {
        return view('livewire.job-view');
    }
}
