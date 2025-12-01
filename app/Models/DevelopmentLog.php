<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevelopmentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'log_date',
        'category',
        'title',
        'description',
        'media',
        'logged_by'
    ];

    protected $casts = [
        'log_date' => 'date',
        'media' => 'array',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function loggedBy()
    {
        return $this->belongsTo(User::class, 'logged_by');
    }

    public function scopeMotorSkills($query)
    {
        return $query->where('category', 'motor_skills');
    }

    public function scopeLanguage($query)
    {
        return $query->where('category', 'language');
    }

    public function scopeSocialSkills($query)
    {
        return $query->where('category', 'social_skills');
    }

    public function scopeCognitive($query)
    {
        return $query->where('category', 'cognitive');
    }
}