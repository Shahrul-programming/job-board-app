@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Check if we should use simple version for debugging -->
    @if(request()->has('simple'))
        <livewire:admin.simple-user-management />
    @else
        <livewire:admin.user-management />
    @endif
</div>
@endsection

@section('title', 'User Management - Admin Panel')