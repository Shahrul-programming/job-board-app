@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-6">
                Find Your Dream Job
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                Connect with top employers and discover opportunities that match your skills and passion.
            </p>
        </div>
    </div>
</section>

<!-- Job Board Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                Latest Opportunities
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Explore the newest job postings and find your next career move.
            </p>
        </div>

        <!-- Interactive Job Board Components -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Side: Job Create Form (for authenticated users) -->
            @auth
                <div class="lg:w-1/2 order-2 lg:order-1">
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                            Post a New Job
                        </h3>
                        <livewire:job-create />
                    </div>
                </div>
            @endauth
            
            <!-- Right Side: Search Bar + Job List -->
            <div class="@auth lg:w-1/2 @else w-full @endauth order-1 @auth lg:order-2 @endif">
                <div class="space-y-6">
                    <!-- Job Search Component -->
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                            Find Your Perfect Job
                        </h3>
                        <livewire:job-search />
                    </div>
                    
                    <!-- Job List Component -->
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
                        <livewire:job-list />
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hidden Components for Modal/Overlay functionality -->
        <livewire:job-edit />
        <livewire:job-view />
        <livewire:job-apply />
    </div>
</section>

<!-- Call to Action Section -->
@guest
<section class="py-20 bg-blue-600 dark:bg-blue-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Get Started?
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            Join thousands of job seekers and employers who trust our platform.
        </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 text-lg font-semibold rounded-lg hover:bg-gray-100 transition duration-300 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Sign Up Free
                </a>
            @endif
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white text-lg font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013 3v1" />
                    </svg>
                    Sign In
                </a>
            @else
                <a href="#" class="inline-flex items-center px-8 py-4 border-2 border-white text-white text-lg font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013 3v1" />
                    </svg>
                    Get Started
                </a>
            @endif
        </div>
    </div>
</section>
@endguest
@endsection
