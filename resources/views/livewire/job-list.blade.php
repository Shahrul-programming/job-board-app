<div x-data="{ mounted: false }" x-init="$nextTick(() => mounted = true)" class="w-full px-4 sm:px-6 lg:px-8">
    <!-- Job Cards -->
    <div class="space-y-4">
        @forelse($jobs as $index => $job)
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-600 ease-out"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition-all duration-400 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                :style="`transition-delay: ${{ $index * 0.1 }}s`"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <!-- Job Title -->
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                            {{ $job['title'] }}
                        </h3>

                        <!-- Company -->
                        <div class="flex items-center mb-2 group">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300 font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                                {{ $job['company'] }}
                            </span>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center mb-3 group">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2 group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-200">
                                {{ $job['location'] }}
                            </span>
                        </div>

                        <!-- Posted Date -->
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 group">
                            <svg class="w-4 h-4 mr-1 group-hover:text-amber-500 dark:group-hover:text-amber-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Posted recently
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="ml-4 flex space-x-2">

                        <!-- View Button -->
                        <button wire:click="viewJob({{ $job->id }})"
                                class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-all duration-200 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 hover:scale-110 hover:shadow-md"
                                title="View job details">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>

                        <!-- Edit Button -->
                        <button wire:click="editJob({{ $job->id }})"
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-all duration-200 p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:scale-110 hover:shadow-md"
                                title="Edit job">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>

                        <!-- Delete Button -->
                        <button wire:click="deleteJob({{ $job->id }})"
                                wire:confirm="Are you sure you want to delete this job listing?"
                                class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-all duration-200 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 hover:scale-110 hover:shadow-md"
                                title="Delete job">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-600 ease-out delay-300"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition-all duration-400 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center border border-gray-200 dark:border-gray-700">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6m0 0v4a2 2 0 002 2h12a2 2 0 002-2v-4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">No jobs found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    There are no job listings available at the moment.
                </p>
            </div>
        @endforelse
    </div>
</div>
