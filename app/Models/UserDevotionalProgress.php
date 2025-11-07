<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserDevotionalProgress extends Model
{
    protected $table = 'user_devotional_progress';

    protected $fillable = [
        'user_id',
        'devotional_plan_id',
        'current_day',
        'started_at',
        'completed_at',
        'last_activity_at',
    ];

    protected $casts = [
        'current_day' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the devotional plan
     */
    public function devotionalPlan(): BelongsTo
    {
        return $this->belongsTo(DevotionalPlan::class);
    }

    /**
     * Advance to the next day
     */
    public function advanceDay(): bool
    {
        if ($this->current_day < $this->devotionalPlan->duration_days) {
            $this->current_day++;
            $this->last_activity_at = now();
            
            // Check if this completes the plan
            if ($this->current_day > $this->devotionalPlan->duration_days) {
                $this->completed_at = now();
            }
            
            return $this->save();
        }
        
        return false;
    }

    /**
     * Check if plan is completed
     */
    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }

    /**
     * Get completion percentage
     */
    public function getProgressPercentageAttribute(): float
    {
        $totalDays = $this->devotionalPlan->duration_days;
        if ($totalDays === 0) return 0;
        
        return round(($this->current_day / $totalDays) * 100, 1);
    }

    /**
     * Get days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        return max(0, $this->devotionalPlan->duration_days - $this->current_day + 1);
    }

    /**
     * Scope for active (not completed) progress
     */
    public function scopeActive($query)
    {
        return $query->whereNull('completed_at');
    }

    /**
     * Scope for completed progress
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }
}

