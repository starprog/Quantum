<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = ['name', 'path', 'provider', 'enabled', 'settings'];

    protected $casts = [
        'enabled' => 'boolean',
        'settings' => 'array',
    ];
}
