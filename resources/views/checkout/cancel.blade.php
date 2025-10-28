@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <!-- Cancel Icon -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100">
                <svg class="h-10 w-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Payment Cancelled
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Your payment was cancelled. No charges were made to your account.
            </p>
            
            @if(request('job_id'))
            <div class="mt-2 text-center text-xs text-gray-500">
                Job ID: #{{ request('job_id') }}
            </div>
            @endif
            
            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                <p class="text-sm text-yellow-800">
                    ⚠️ Your job posting remains <strong>PENDING</strong> until payment is completed.
                </p>
            </div>
        </div>
        
        <div class="text-center space-y-4">
            <a href="{{ route('checkout') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Complete Payment
            </a>
            <a href="{{ route('dashboard') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection