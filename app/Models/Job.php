<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_lists';

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'status',
        'payment_intent_id',
        'activated_at',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
    ];

    /**
     * Scope to get only active jobs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get pending jobs
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Activate the job after successful payment
     */
    public function activate(?string $paymentIntentId = null): void
    {
        $this->update([
            'status' => 'active',
            'payment_intent_id' => $paymentIntentId,
            'activated_at' => now(),
        ]);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
