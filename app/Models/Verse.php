<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Verse extends Model
{
    protected $fillable = [
        'verse',
        'reference',
        'category_id',
        'is_featured'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(VerseCategory::class);
    }

    /**
     * The users who have favorited this verse.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_favorite_verses')
            ->withTimestamps();
    }

    /**
     * The collections that contain this verse.
     */
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(VerseCollection::class, 'collection_verses')
            ->withTimestamps()
            ->withPivot('order')
            ->orderBy('order');
    }

    /**
     * Get the count of users who favorited this verse.
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->favoritedBy()->count();
    }
}

