<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/test', function () {
    return 'Hello World - Laravel is working!';
});

Route::get('/test-csrf', function () {
    return view('test-csrf');
})->name('test.csrf');

Route::get('/quick-login-test', function () {
    return view('quick-login-test');
})->name('quick.login.test');

Route::get('/session-debug', function () {
    return view('session-debug');
})->name('session.debug');

// Test routes for debugging
Route::get('/test-session', function () {
    return view('test-session');
})->name('test.session');

Route::post('/test-session', function () {
    return redirect('/test-session')->with('success', 'CSRF test successful! Token: '.csrf_token());
});

Route::get('/clear-session', function () {
    Session::flush();
    Session::regenerate();
    Auth::logout();

    return redirect('/test-session')->with('success', 'Session cleared successfully');
});

Route::get('/check-auth', function () {
    \Log::info('Check auth endpoint called', [
        'user' => auth()->user() ? auth()->user()->toArray() : null,
        'auth_check' => auth()->check(),
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
    ]);

    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
    ]);
});

Route::get('/test-auth', function () {
    return view('test-auth');
});

// Test routes for CSRF debugging
Route::post('/test-csrf-protected', function () {
    return response()->json(['success' => true, 'message' => 'CSRF token valid']);
})->middleware('web');

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
    ->name('login')->middleware('guest');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->name('login.post');

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])
    ->name('register')->middleware('guest');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
    ->name('register.post');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout');

// Public Job Routes (no authentication required for viewing)
Route::get('/jobs', [App\Http\Controllers\JobController::class, 'index'])
    ->name('jobs.index');

Route::get('/jobs/{job}', [App\Http\Controllers\JobController::class, 'show'])
    ->name('jobs.show');

// Protected Job Routes (authentication required)
Route::middleware('auth')->group(function () {
    Route::get('/jobs/create', [App\Http\Controllers\JobController::class, 'create'])
        ->name('jobs.create');
});

// Dashboard Routes - Single dashboard for both admin and guest
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard')->middleware('auth');

// Admin-specific routes (protected by policy)
Route::get('/applications', [App\Http\Controllers\DashboardController::class, 'applications'])
    ->name('applications.index')->middleware('auth');

// Remove old admin routes - now using single dashboard
// Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
//     ->name('admin.dashboard')->middleware('auth');

// Route::get('/admin/applications', [App\Http\Controllers\Admin\DashboardController::class, 'applications'])
//     ->name('admin.applications')->middleware('auth');
