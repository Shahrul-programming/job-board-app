<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        // Add debug logging for CSRF issues
        if (app()->environment('local')) {
            \Log::info('CSRF Token Check', [
                'session_token' => $request->session()->token(),
                'request_token' => $request->header('X-CSRF-TOKEN') ?: $request->input('_token'),
                'url' => $request->url(),
                'method' => $request->method(),
                'session_id' => $request->session()->getId(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        try {
            return parent::handle($request, $next);
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            // Log detailed error for debugging
            if (app()->environment('local')) {
                \Log::error('CSRF Token Mismatch', [
                    'session_token' => $request->session()->token(),
                    'request_token' => $request->header('X-CSRF-TOKEN') ?: $request->input('_token'),
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'session_id' => $request->session()->getId(),
                    'user_agent' => $request->userAgent(),
                    'error' => $e->getMessage(),
                ]);
            }

            // Regenerate session and redirect back with error message
            $request->session()->regenerate();

            return redirect()->back()->with('error', 'Your session has expired. Please try again.');
        }
    }
}
