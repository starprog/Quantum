<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'universe',
        'strength',
        'powers',
        'durability',
        'endurance',
    ];

    protected $casts = [
        'strength' => 'integer',
        'powers' => 'integer',
        'durability' => 'integer',
        'endurance' => 'integer',
    ];
}