<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $stats = [
            'total_jobs' => Job::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'total_applications' => JobApplication::count(),
            'recent_jobs' => Job::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function applications()
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $applications = JobApplication::with('job')
            ->latest()
            ->paginate(15);

        return view('admin.applications', compact('applications'));
    }
}
