<?php

namespace App\Livewire;

use App\Models\JobApplication;
use Livewire\Component;
use Livewire\WithPagination;

class MyApplications extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    protected $queryString = ['statusFilter'];

    public function filterByStatus($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function render()
    {
        $query = JobApplication::with(['job', 'user'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $applications = $query->paginate(10);

        $statusCounts = [
            'all' => JobApplication::where('user_id', auth()->id())->count(),
            'pending' => JobApplication::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'reviewed' => JobApplication::where('user_id', auth()->id())->where('status', 'reviewed')->count(),
            'shortlisted' => JobApplication::where('user_id', auth()->id())->where('status', 'shortlisted')->count(),
            'rejected' => JobApplication::where('user_id', auth()->id())->where('status', 'rejected')->count(),
        ];

        return view('livewire.my-applications', [
            'applications' => $applications,
            'statusCounts' => $statusCounts,
        ]);
    }
}
