<?php

namespace App\Http\Controllers;

use App\Models\Job;

class JobController extends Controller
{
    /**
     * Display a listing of jobs (public access).
     */
    public function index()
    {
        return view('jobs.index');
    }

    /**
     * Show the form for creating a new job (auth required).
     */
    public function create()
    {
        $this->middleware('auth');

        if (! auth()->user()->can('createJobs', auth()->user())) {
            abort(403, 'Only admins can create jobs.');
        }

        return view('jobs.create');
    }

    /**
     * Display the specified job (public access).
     */
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }
}
