<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Applications</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Track and manage all your job applications</p>
        </div>

        <!-- Status Filter Tabs -->
        <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8 overflow-x-auto">
                <button wire:click="filterByStatus('all')" 
                        class="@if($statusFilter === 'all') border-blue-500 text-blue-600 dark:text-blue-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    All Applications
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs @if($statusFilter === 'all') bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300 @else bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 @endif">
                        {{ $statusCounts['all'] }}
                    </span>
                </button>
                
                <button wire:click="filterByStatus('pending')" 
                        class="@if($statusFilter === 'pending') border-yellow-500 text-yellow-600 dark:text-yellow-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Pending
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs @if($statusFilter === 'pending') bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300 @else bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 @endif">
                        {{ $statusCounts['pending'] }}
                    </span>
                </button>
                
                <button wire:click="filterByStatus('reviewed')" 
                        class="@if($statusFilter === 'reviewed') border-indigo-500 text-indigo-600 dark:text-indigo-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Reviewed
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs @if($statusFilter === 'reviewed') bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300 @else bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 @endif">
                        {{ $statusCounts['reviewed'] }}
                    </span>
                </button>
                
                <button wire:click="filterByStatus('shortlisted')" 
                        class="@if($statusFilter === 'shortlisted') border-green-500 text-green-600 dark:text-green-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Shortlisted
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs @if($statusFilter === 'shortlisted') bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300 @else bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 @endif">
                        {{ $statusCounts['shortlisted'] }}
                    </span>
                </button>
                
                <button wire:click="filterByStatus('rejected')" 
                        class="@if($statusFilter === 'rejected') border-red-500 text-red-600 dark:text-red-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Rejected
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs @if($statusFilter === 'rejected') bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300 @else bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 @endif">
                        {{ $statusCounts['rejected'] }}
                    </span>
                </button>
            </nav>
        </div>

        <!-- Applications List -->
        @if($applications->count() > 0)
            <div class="space-y-4">
                @foreach($applications as $application)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $application->job->title }}
                                        </h3>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($application->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($application->status === 'reviewed') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300
                                            @elseif($application->status === 'shortlisted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @elseif($application->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $application->job->company }}
                                    </p>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $application->job->location }}
                                    </p>
                                    
                                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                        <span>
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Applied {{ $application->created_at->diffForHumans() }}
                                        </span>
                                        @if($application->job->employment_type)
                                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-gray-700 dark:text-gray-300">
                                                {{ ucfirst($application->job->employment_type) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="ml-4">
                                    <a href="{{ route('jobs.show', $application->job->id) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        View Job
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 712-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No applications found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    @if($statusFilter === 'all')
                        You haven't applied to any jobs yet.
                    @else
                        No applications with "{{ $statusFilter }}" status.
                    @endif
                </p>
                <div class="mt-6">
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 712 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 712-2V6"></path>
                        </svg>
                        Browse Available Jobs
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
