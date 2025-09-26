@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Dashboard</h1>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Welcome back, {{ auth()->user()->name ?? 'User' }}!
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Stats Card 1 -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Jobs</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ \App\Models\Job::count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 2 -->
                    <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-green-600 dark:text-green-400">Your Applications</p>
                                <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ \App\Models\JobApplication::where('email', auth()->user()->email)->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 3 -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 p-6 rounded-lg border border-purple-200 dark:border-purple-800">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Profile Views</p>
                                <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">0</p>
                            </div>
                        </div>
                    </div>
                <!-- Job List Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Available Jobs</h2>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <livewire:job-list />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection