<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of jobs (public access).
     */
    public function index()
    {
        // Get only active jobs for public display
        $jobs = Job::where('status', 'active')
            ->latest()
            ->paginate(12);

        $totalActiveJobs = Job::where('status', 'active')->count();

        return view('jobs.index', compact('jobs', 'totalActiveJobs'));
    }

    /**
     * Show the form for creating a new job (admin only).
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created job (admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|in:full-time,part-time,contract,internship',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
        ]);

        // Create job with pending status by default
        $job = Job::create(array_merge($validated, [
            'status' => 'pending',
        ]));

        // Store job ID in session for webhook processing
        session(['pending_job_id' => $job->id]);

        // Redirect to checkout after successful job creation
        return redirect()->route('checkout')->with([
            'success' => 'Job created successfully! Please complete payment to publish the job.',
            'job_id' => $job->id,
            'job_title' => $job->title
        ]);
    }

    /**
     * Display the specified job (public access).
     */
    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        // Check if user can edit this job
        if (auth()->user()->cannot('update', $job)) {
            abort(403, 'Unauthorized to edit this job.');
        }

        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(Request $request, Job $job)
    {
        // Check if user can update this job
        if (auth()->user()->cannot('update', $job)) {
            abort(403, 'Unauthorized to update this job.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract,freelance'
        ]);

        $job->update($request->all());

        return redirect()->route('jobs.show', $job)->with('success', 'Job updated successfully!');
    }

    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }
}
