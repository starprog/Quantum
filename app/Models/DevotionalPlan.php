<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DevotionalPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_days',
        'is_active',
        'slug',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_days' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            if (empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });
    }

    /**
     * Get the verses for this plan
     */
    public function planVerses(): HasMany
    {
        return $this->hasMany(DevotionalPlanVerse::class)->orderBy('day_number');
    }

    /**
     * Get user progress records for this plan
     */
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserDevotionalProgress::class);
    }

    /**
     * Scope to get only active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get verse for a specific day
     */
    public function getVerseForDay(int $day)
    {
        return $this->planVerses()->where('day_number', $day)->first();
    }

    /**
     * Check if plan is complete (has verses for all days)
     */
    public function isComplete(): bool
    {
        return $this->planVerses()->count() === $this->duration_days;
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentageAttribute(): float
    {
        if ($this->duration_days === 0) return 0;
        return round(($this->planVerses()->count() / $this->duration_days) * 100, 1);
    }
}

