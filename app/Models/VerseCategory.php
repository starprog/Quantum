<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VerseCategory extends Model
{
    protected $fillable = [
        'name',
        'slug', 
        'description'
    ];

    public function verses(): HasMany
    {
        return $this->hasMany(Verse::class, 'category_id');
    }
}
