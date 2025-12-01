<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'milestone_id',
        'achieved_date',
        'is_achieved',
        'age_achieved_months',
        'notes',
        'photo',
        'video',
        'recorded_by'
    ];

    protected $casts = [
        'achieved_date' => 'date',
        'is_achieved' => 'boolean',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function scopeAchieved($query)
    {
        return $query->where('is_achieved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_achieved', false);
    }
}