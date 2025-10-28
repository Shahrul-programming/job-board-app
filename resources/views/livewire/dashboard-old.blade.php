<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Dashboard</h1>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Welcome back, {{ $user->name ?? 'User' }}! 
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        @can('isAdmin', $user)
            <!-- Admin Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $totalJobs }}</h2>
                            <p class="text-sm text-blue-700 dark:text-blue-200">Total Jobs</p>
                        </div>
                        <div class="ml-4">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $adminData['totalApplications'] ?? 0 }}</h2>
                            <p class="text-sm text-green-700 dark:text-green-200">Total Applications</p>
                        </div>
                        <div class="ml-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-yellow-600 dark:text-yellow-300">{{ $adminData['pendingApplications'] ?? 0 }}</h2>
                            <p class="text-sm text-yellow-700 dark:text-yellow-200">Pending Applications</p>
                        </div>
                        <div class="ml-4">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 dark:bg-purple-900 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-purple-600 dark:text-purple-300">{{ $adminData['totalUsers'] ?? 0 }}</h2>
                            <p class="text-sm text-purple-700 dark:text-purple-200">Total Users</p>
                        </div>
                        <div class="ml-4">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Quick Actions -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                    Admin Actions
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-base font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create New Job
                    </a>
                    <a href="{{ route('applications.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-base font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Manage Applications
                    </a>
                    <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white text-base font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Manage Users
                    </a>
                </div>
            </div>

            <!-- Compact Admin Job Creation Form -->
            <!-- <div class="mb-6">
                <livewire:admin.admin-job-create />
            </div> -->
        @else
            <!-- Guest Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $totalJobs }}</h2>
                            <p class="text-sm text-blue-700 dark:text-blue-200">Available Jobs</p>
                        </div>
                        <div class="ml-4">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $guestData['myApplicationsCount'] ?? 0 }}</h2>
                            <p class="text-sm text-green-700 dark:text-green-200">My Applications</p>
                        </div>
                        <div class="ml-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($guestData['myApplications']) && $guestData['myApplications']->count() > 0)
                <!-- My Recent Applications -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                        My Recent Applications
                    </h3>
                    <div class="space-y-3">
                        @foreach($guestData['myApplications'] as $application)
                            <div class="bg-white dark:bg-gray-600 rounded-lg p-4 flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $application->job->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Applied on {{ $application->created_at->format('M j, Y') }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status === 'approved') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endcan

        <!-- Job List Section - Full Width Layout -->
        <div class="w-full">
            <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-6">Job Management</h2>
            
            <!-- Single Column Layout: Search & Job List -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Job Search Component -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                        Find Your Perfect Job
                    </h3>
                    {{-- <livewire:job-search /> --}}
                </div>
                
                <!-- Job List Component -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-8 min-h-[50vh]">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Available Jobs</h3>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $totalJobs }} job{{ $totalJobs !== 1 ? 's' : '' }} available
                        </div>
                    </div>
                    {{-- <livewire:job-list /> --}}
                </div>
            </div>
        </div>
    </div>
</div>
