<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class JobList extends Component
{
    public $jobs = [];

    #[On('jobCreated')]
    public function handleJobCreated($job)
    {
        $this->jobs[] = $job;
    }

    public function render()
    {
        return view('livewire.job-list');
    }
}
