<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard for both admin and guest users
     */
    public function index()
    {
        $user = auth()->user();

        // Get jobs data
        $jobs = Job::latest()->take(10)->get();
        $totalJobs = Job::count();

        // Admin-specific data
        $adminData = [];
        if (Gate::allows('isAdmin', $user)) {
            $adminData = [
                'totalApplications' => JobApplication::count(),
                'pendingApplications' => JobApplication::where('status', 'pending')->count(),
                'recentApplications' => JobApplication::with(['job', 'user'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'totalUsers' => User::count(),
            ];
        }

        // Guest-specific data (applications made by this user)
        $guestData = [];
        if (Gate::denies('isAdmin', $user)) {
            $guestData = [
                'myApplications' => JobApplication::where('user_id', $user->id)
                    ->with('job')
                    ->latest()
                    ->take(5)
                    ->get(),
                'myApplicationsCount' => JobApplication::where('user_id', $user->id)->count(),
            ];
        }

        return view('dashboard', compact('jobs', 'totalJobs', 'adminData', 'guestData', 'user'));
    }

    /**
     * Show all job applications (Admin only)
     */
    public function applications()
    {
        $user = auth()->user();

        if (Gate::denies('viewApplications', $user)) {
            abort(403, 'Unauthorized');
        }

        $applications = JobApplication::with(['job', 'user'])
            ->latest()
            ->paginate(15);

        return view('applications.index', compact('applications'));
    }
}
