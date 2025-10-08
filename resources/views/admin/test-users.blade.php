@extends('layouts.admin')

@section('title', 'User Management - Test')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">User Management - Static Test</h1>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-gray-600 dark:text-gray-400 mb-4">This is a static test page to verify the layout works.</p>
            
            <div class="space-y-4">
                <p><strong>Current User:</strong> {{ auth()->user()->name ?? 'Not logged in' }}</p>
                <p><strong>User Role:</strong> {{ auth()->user()->role ?? 'N/A' }}</p>
                <p><strong>Current Route:</strong> {{ Route::currentRouteName() }}</p>
                <p><strong>Timestamp:</strong> {{ now() }}</p>
            </div>
            
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="mt-6">
                    <a href="{{ route('admin.users') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Go to Real Admin Users Page
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection