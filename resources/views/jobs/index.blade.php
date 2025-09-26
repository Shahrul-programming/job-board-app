@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Job Listings</h1>
                    @guest
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500">Login</a> or 
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500">Register</a> to apply for jobs
                        </div>
                    @endguest
                </div>

                <!-- Search Section -->
                <div class="mb-8">
                    @livewire('jobsearch')
                </div>

                <!-- Jobs List -->
                <div class="space-y-6">
                    @livewire('job-list')
                </div>

                <!-- Livewire Components for Modal Views (Available for all users) -->
                @livewire('job-view')
                
                @auth
                    <!-- Job Apply Modal (Only shown if authenticated) -->
                    @livewire('job-apply')
                    
                    @can('createJobs', auth()->user())
                        <!-- Job Create Modal (Only for admins) -->
                        @livewire('job-create')
                    @endcan
                    
                    @can('editJobs', auth()->user())
                        <!-- Job Edit Modal (Only for admins) -->
                        @livewire('job-edit')
                    @endcan
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection