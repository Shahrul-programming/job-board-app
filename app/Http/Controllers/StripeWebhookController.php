<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    /**
     * Handle successful payment
     */
    public function handlePaymentIntentSucceeded($payload)
    {
        // Log the event with full details
        \Log::info('Payment succeeded - Processing webhook', [
            'type' => $payload['type'] ?? 'unknown',
            'data' => $payload['data'] ?? []
        ]);

        // Get payment intent data
        $paymentIntent = $payload['data']['object'];
        $paymentIntentId = $paymentIntent['id'];
        $metadata = $paymentIntent['metadata'] ?? [];

        \Log::info('Payment Intent Details', [
            'payment_intent_id' => $paymentIntentId,
            'metadata' => $metadata
        ]);

        // Find job by metadata job_id (most reliable)
        $job = null;
        if (isset($metadata['job_id'])) {
            $job = Job::where('id', $metadata['job_id'])
                     ->where('status', 'pending')
                     ->first();
            
            \Log::info('Looking for job by metadata', [
                'job_id' => $metadata['job_id'],
                'job_found' => $job ? 'Yes' : 'No'
            ]);
        }

        // Fallback: try to find by payment_intent_id
        if (!$job) {
            $job = Job::where('payment_intent_id', $paymentIntentId)->first();
            \Log::info('Fallback: Looking for job by payment_intent_id', [
                'payment_intent_id' => $paymentIntentId,
                'job_found' => $job ? 'Yes' : 'No'
            ]);
        }

        // Last resort: get latest pending job for user
        if (!$job && isset($metadata['user_id'])) {
            $job = Job::where('status', 'pending')
                     ->where('created_at', '>=', now()->subHours(2)) // Only jobs created in last 2 hours
                     ->latest()
                     ->first();
            
            \Log::info('Last resort: Looking for recent pending job', [
                'user_id' => $metadata['user_id'],
                'job_found' => $job ? 'Yes' : 'No'
            ]);
        }

        if ($job && $job->status === 'pending') {
            // Activate the job
            $job->activate($paymentIntentId);

            \Log::info('✅ Job activated successfully', [
                'job_id' => $job->id,
                'job_title' => $job->title,
                'payment_intent_id' => $paymentIntentId,
                'user_id' => $metadata['user_id'] ?? 'unknown'
            ]);
            
            // Clear the pending job session since it's now activated
            session()->forget('pending_job_id');
            
        } else {
            \Log::warning('❌ Could not find pending job for payment', [
                'payment_intent_id' => $paymentIntentId,
                'metadata' => $metadata,
                'job_found' => $job ? $job->id : 'none',
                'job_status' => $job ? $job->status : 'N/A'
            ]);
        }

        return parent::handlePaymentIntentSucceeded($payload);
    }

    /**
     * Handle failed payment
     */
    public function handlePaymentIntentFailed($payload)
    {
        // Handle failed payment
        \Log::error('Payment failed', $payload);

        $paymentIntent = $payload['data']['object'];
        $paymentIntentId = $paymentIntent['id'];

        // Find the job and keep it as pending
        $job = Job::where('payment_intent_id', $paymentIntentId)->first();

        if ($job) {
            \Log::error('Job payment failed, keeping as pending', [
                'job_id' => $job->id,
                'job_title' => $job->title,
                'payment_intent_id' => $paymentIntentId,
            ]);
        }

        return parent::handlePaymentIntentFailed($payload);
    }

    /**
     * Handle checkout session completed
     */
    public function handleCheckoutSessionCompleted($payload)
    {
        // Handle completed checkout session
        \Log::info('Checkout session completed', $payload);

        $session = $payload['data']['object'];

        // Get the payment intent from the session
        if (isset($session['payment_intent'])) {
            $paymentIntentId = $session['payment_intent'];

            // Find and activate the job
            $job = Job::where('status', 'pending')->latest()->first();

            if ($job) {
                $job->update(['payment_intent_id' => $paymentIntentId]);
                \Log::info('Updated job with payment intent ID', [
                    'job_id' => $job->id,
                    'payment_intent_id' => $paymentIntentId,
                ]);
            }
        }

        return parent::handleCheckoutSessionCompleted($payload);
    }
}
