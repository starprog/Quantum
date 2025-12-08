<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'min_age_months',
        'max_age_months',
        'category',
        'duration',
        'materials',
        'instructions',
        'difficulty',
        'developmental_benefits',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_age_months' => 'integer',
        'max_age_months' => 'integer',
    ];

    /**
     * Get activities for a specific age in months
     */
    public static function forAge($ageInMonths)
    {
        return self::where('is_active', true)
            ->where('min_age_months', '<=', $ageInMonths)
            ->where('max_age_months', '>=', $ageInMonths)
            ->orderBy('category')
            ->get();
    }

    /**
     * Get activities by category
     */
    public static function byCategory($category)
    {
        return self::where('category', $category)
            ->where('is_active', true)
            ->orderBy('min_age_months')
            ->get();
    }

    /**
     * Get age range display
     */
    public function getAgeRangeAttribute()
    {
        $minYears = floor($this->min_age_months / 12);
        $minMonths = $this->min_age_months % 12;
        $maxYears = floor($this->max_age_months / 12);
        $maxMonths = $this->max_age_months % 12;

        $min = $minYears > 0 ? "{$minYears}y {$minMonths}m" : "{$minMonths}m";
        $max = $maxYears > 0 ? "{$maxYears}y {$maxMonths}m" : "{$maxMonths}m";

        return "{$min} - {$max}";
    }

    /**
     * Get formatted category name
     */
    public function getCategoryNameAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->category));
    }
}