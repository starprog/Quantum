<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'user_id',
        'relationship',
        'access_level',
        'can_edit',
        'is_primary'
    ];

    protected $casts = [
        'can_edit' => 'boolean',
        'is_primary' => 'boolean',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeCanEdit($query)
    {
        return $query->where('can_edit', true);
    }
}