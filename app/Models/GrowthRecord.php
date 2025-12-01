<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'recorded_date',
        'age_in_months',
        'weight_kg',
        'height_cm',
        'head_circumference_cm',
        'notes'
    ];

    protected $casts = [
        'recorded_date' => 'date',
        'weight_kg' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'head_circumference_cm' => 'decimal:2',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    // Helper methods for percentile calculations (can be enhanced with WHO growth standards)
    public function getWeightPercentile()
    {
        // TODO: Implement WHO growth chart calculations
        return null;
    }

    public function getHeightPercentile()
    {
        // TODO: Implement WHO growth chart calculations
        return null;
    }
}