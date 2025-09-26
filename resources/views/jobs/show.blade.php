@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Job Details -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">{{ $job->title }}</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Company</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $job->company }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $job->location }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Job Type</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ ucfirst($job->job_type) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Salary</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Requirements</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Posted {{ $job->created_at->diffForHumans() }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('jobs.index') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                            Back to Jobs
                        </a>
                        
                        @auth
                            <!-- Job Apply trigger for Livewire component -->
                            <button onclick="window.dispatchEvent(new CustomEvent('open-job-apply', { detail: { jobId: {{ $job->id }} } }));"
                                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                Apply Now
                            </button>
                        @else
                            <div class="flex space-x-2">
                                <a href="{{ route('login', ['redirect' => request()->url()]) }}" 
                                   class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    Login to Apply
                                </a>
                                <a href="{{ route('register', ['redirect' => request()->url()]) }}" 
                                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                    Register & Apply
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@auth
    <!-- Include Livewire components for authenticated users -->
    @livewire('job-apply')
@endauth
@endsection