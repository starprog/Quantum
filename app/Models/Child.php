<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Child extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'profile_photo',
        'notes'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    protected $appends = ['age_in_months', 'age_display', 'full_name'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function caregivers()
    {
        return $this->hasMany(Caregiver::class);
    }

    public function growthRecords()
    {
        return $this->hasMany(GrowthRecord::class)->orderBy('recorded_date', 'desc');
    }

    public function milestones()
    {
        return $this->hasMany(ChildMilestone::class);
    }

    public function achievedMilestones()
    {
        return $this->hasMany(ChildMilestone::class)->where('is_achieved', true);
    }

    public function developmentLogs()
    {
        return $this->hasMany(DevelopmentLog::class)->orderBy('log_date', 'desc');
    }

    // Accessors
    public function getAgeInMonthsAttribute()
    {
        return $this->date_of_birth->diffInMonths(now());
    }

    public function getAgeDisplayAttribute()
    {
        $months = $this->age_in_months;
        
        if ($months < 12) {
            return $months . ' month' . ($months !== 1 ? 's' : '');
        }
        
        $years = floor($months / 12);
        $remainingMonths = $months % 12;
        
        $display = $years . ' year' . ($years !== 1 ? 's' : '');
        
        if ($remainingMonths > 0) {
            $display .= ', ' . $remainingMonths . ' month' . ($remainingMonths !== 1 ? 's' : '');
        }
        
        return $display;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Helper methods
    public function getAgeRangeCategory()
    {
        $months = $this->age_in_months;
        
        if ($months <= 3) return '0-3';
        if ($months <= 6) return '3-6';
        if ($months <= 9) return '6-9';
        if ($months <= 12) return '9-12';
        if ($months <= 18) return '12-18';
        if ($months <= 24) return '18-24';
        if ($months <= 36) return '24-36';
        if ($months <= 48) return '36-48';
        
        return '48+';
    }

    public function getRecommendedMilestones()
    {
        $ageInMonths = $this->age_in_months;
        
        return Milestone::where('typical_age_months_min', '<=', $ageInMonths)
            ->where('typical_age_months_max', '>=', $ageInMonths)
            ->where('is_active', true)
            ->get();
    }

    public function getLatestGrowthRecord()
    {
        return $this->growthRecords()->first();
    }
}