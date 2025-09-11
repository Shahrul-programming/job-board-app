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
        $job = Job::create([
            'title' => $this->title,
            'company' => $this->company,
            'location' => $this->location,
            'description' => $this->description,
        ]);

        $this->dispatch('jobCreated', $job->id);

        $this->clear();
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
