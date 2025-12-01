<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'typical_age_months_min',
        'typical_age_months_max',
        'age_range',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function childMilestones()
    {
        return $this->hasMany(ChildMilestone::class);
    }

    public function scopePhysical($query)
    {
        return $query->where('category', 'physical');
    }

    public function scopeCognitive($query)
    {
        return $query->where('category', 'cognitive');
    }

    public function scopeLanguage($query)
    {
        return $query->where('category', 'language');
    }

    public function scopeSocialEmotional($query)
    {
        return $query->where('category', 'social_emotional');
    }

    public function scopeFineMotor($query)
    {
        return $query->where('category', 'fine_motor');
    }

    public function scopeGrossMotor($query)
    {
        return $query->where('category', 'gross_motor');
    }

    public function scopeForAgeRange($query, $ageRange)
    {
        return $query->where('age_range', $ageRange);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}