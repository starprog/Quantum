<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevotionalPlanVerse extends Model
{
    protected $fillable = [
        'devotional_plan_id',
        'verse_id',
        'day_number',
        'reflection_text',
    ];

    protected $casts = [
        'day_number' => 'integer',
    ];

    /**
     * Get the plan this verse belongs to
     */
    public function devotionalPlan(): BelongsTo
    {
        return $this->belongsTo(DevotionalPlan::class);
    }

    /**
     * Get the verse
     */
    public function verse(): BelongsTo
    {
        return $this->belongsTo(Verse::class);
    }
}

