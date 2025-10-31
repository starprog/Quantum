<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verse extends Model
{
    protected $fillable = [
        'verse',
        'reference',
        'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(VerseCategory::class);
    }

    /**
     * The users who have favorited this verse.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorite_verses')
            ->withTimestamps();
    }
}
