<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;

class CheckoutController extends Controller
{
    /**
     * Handle checkout success and automatically activate the job
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $jobId = $request->get('job_id');
        
        Log::info('ï¿½ï¿½ Checkout Success Page Accessed', [
            'session_id' => $sessionId,
            'job_id' => $jobId,
            'all_params' => $request->all(),
            'timestamp' => now()
        ]);

        $job = null;
        $activationResult = 'No job to activate';

        // Try to find and activate the job
        if ($jobId) {
            $job = Job::find($jobId);
            
            if ($job && $job->status === 'pending') {
                Log::info('í´„ Attempting to activate job from success page', [
                    'job_id' => $job->id,
                    'job_title' => $job->title,
                    'current_status' => $job->status
                ]);

                try {
                    // Activate the job
                    $job->update([
                        'status' => 'active',
                        'payment_intent_id' => 'checkout_success_' . $sessionId,
                        'activated_at' => now()
                    ]);

                    $activationResult = 'success';
                    
                    Log::info('í¾¯ JOB ACTIVATED SUCCESSFULLY from checkout success!', [
                        'job_id' => $job->id,
                        'job_title' => $job->title,
                        'payment_intent_id' => $job->payment_intent_id,
                        'activated_at' => $job->activated_at,
                        'activation_method' => 'checkout_success_page'
                    ]);

                } catch (\Exception $e) {
                    Log::error('âŒ Failed to activate job from success page', [
                        'job_id' => $job->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $activationResult = 'error: ' . $e->getMessage();
                }
            } else {
                $activationResult = $job ? 'Job already active' : 'Job not found';
                Log::info('â„¹ï¸ Job activation skipped', [
                    'job_id' => $jobId,
                    'reason' => $activationResult,
                    'job_status' => $job->status ?? 'n/a'
                ]);
            }
        }

        return view('checkout.success', [
            'sessionId' => $sessionId,
            'jobId' => $jobId,
            'job' => $job,
            'activationResult' => $activationResult
        ]);
    }

    /**
     * Handle checkout cancellation
     */
    public function cancel(Request $request)
    {
        $jobId = $request->get('job_id');
        
        Log::info('âŒ Checkout Cancelled', [
            'job_id' => $jobId,
            'all_params' => $request->all()
        ]);

        $job = null;
        if ($jobId) {
            $job = Job::find($jobId);
        }

        return view('checkout.cancel', [
            'jobId' => $jobId,
            'job' => $job
        ]);
    }
}
