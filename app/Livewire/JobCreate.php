<?php

namespace App\Livewire;

use Livewire\Component;

class JobCreate extends Component
{
    public $title;
    public $company;
    public $location;

    public function save()
    {
        $this->dispatch('jobCreated', job: [
            'title' => $this->title,
            'company' => $this->company,
            'location' => $this->location,
        ]);
    }

    public function render()
    {
        return view('livewire.job-create');
    }
}
