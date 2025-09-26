@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Dashboard</h1>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Welcome back, {{ auth()->user()->name ?? 'User' }}!
                    </div>
                </div>

                <!-- Job List Section - Full Width & Height -->
                <div class="w-full">
                    <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-6">Available Jobs</h2>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-8 min-h-[80vh]">
                        <livewire:job-list />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection